<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Exports\UserTemplateExport;
use App\Imports\UsersImport;
use App\Models\ActivityLog;
use App\Models\System;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\JsonResponse;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query();

        if ($request->filled('type')) {
            $query->where('user_type', $request->type);
        }
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%")
                    ->orWhere('identifier', 'like', "%{$s}%");
            });
        }

        return view('users.index', [
            'users' => $query->latest()->paginate(15)->withQueryString(),
            'stats' => [
                'total' => User::count(),
                'mahasiswa' => User::mahasiswa()->count(),
                'dosen' => User::dosen()->count(),
                'staff' => User::staff()->count(),
                'admin' => User::where('user_type', UserType::ADMIN)->count(),
            ],
            'types' => UserType::cases(),
        ]);
    }

    public function create(): View
    {
        return view('users.create', ['types' => UserType::cases()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateUser($request);
        $validated['password'] = $request->password ?? $validated['identifier'] ?? 'password123';
        $validated['user_type'] = UserType::from($validated['user_type']);

        $user = User::create($validated);

        ActivityLog::log('created', "Menambahkan user baru: {$user->name}", $user);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user): View
    {
        $user->load('systems');
        return view('users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('users.edit', [
            'user' => $user,
            'types' => UserType::cases(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $this->validateUser($request, $user->id);
        $validated['user_type'] = UserType::from($validated['user_type']);

        if ($request->filled('password')) {
            $validated['password'] = $request->password;
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    public function toggleActive(User $user): RedirectResponse
    {
        $user->update(['is_active' => !$user->is_active]);

        return back()->with('success', 'Status user berhasil diubah.');
    }

    public function resetPassword(User $user): RedirectResponse
    {
        $newPassword = Str::random(10);
        $user->update(['password' => $newPassword]);

        return back()->with('success', "Password baru: {$newPassword}");
    }

    public function manageAccess(User $user): View
    {
        return view('users.access', [
            'user' => $user,
            'systems' => System::active()->get(),
            'userAccess' => $user->systems->pluck('pivot.role', 'id')->toArray(),
        ]);
    }

    public function updateAccess(Request $request, User $user): RedirectResponse
    {
        $access = [];
        foreach ($request->input('access', []) as $systemId => $role) {
            if ($role) {
                $access[$systemId] = ['role' => $role];
            }
        }

        $user->systems()->sync($access);

        return redirect()->route('users.access', $user)
            ->with('success', 'Hak akses berhasil diperbarui.');
    }

    public function importForm(): View
    {
        return view('users.import', ['types' => UserType::cases()]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
            'user_type' => ['required', Rule::enum(UserType::class)],
        ]);

        $import = new UsersImport($request->user_type);

        try {
            Excel::import($import, $request->file('file'));

            $success = $import->getSuccessCount();
            $failed = $import->getFailedCount();
            $errors = $import->getErrors();

            // JIKA REQUEST DARI AJAX (Progress Bar)
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "{$success} user berhasil diimport." . ($failed > 0 ? " {$failed} gagal." : ""),
                    'redirect' => route('users.index')
                ]);
            }

            // JIKA REQUEST FORM BIASA
            if ($failed > 0) {
                $errorMsg = "{$success} user berhasil diimport. {$failed} gagal: <br>" . implode('<br>', array_slice($errors, 0, 5));
                if (count($errors) > 5) $errorMsg .= '<br>...dan lainnya.';
                return redirect()->route('users.index')->with('error', $errorMsg);
            }

            return redirect()->route('users.index')
                ->with('success', "{$success} user berhasil diimport.");
        } catch (\Exception $e) {
            // JIKA REQUEST DARI AJAX DAN GAGAL
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memproses file: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Gagal memproses file: ' . $e->getMessage());
        }
    }

    public function downloadTemplate(Request $request)
    {
        $type = $request->input('type', 'mahasiswa');
        $filename = "template-import-{$type}-" . date('Y-m-d') . ".xlsx";

        return Excel::download(new UserTemplateExport($type), $filename);
    }

    protected function validateUser(Request $request, ?int $ignoreId = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($ignoreId)],
            'user_type' => ['required', Rule::enum(UserType::class)],
            'identifier' => ['nullable', 'string', 'max:50', Rule::unique('users')->ignore($ignoreId)],
            'nidn' => ['nullable', 'string', 'max:30'],
            'nik' => ['nullable', 'string', 'max:30'],
            'fakultas' => ['nullable', 'string', 'max:100'],
            'program_studi' => ['nullable', 'string', 'max:100'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'angkatan' => ['nullable', 'string', 'max:10'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'is_active' => ['boolean'],
            'is_super_admin' => ['boolean'],
        ]);

        // Sinkronisasi identifier dengan nidn/nik
        $type = $validated['user_type'];
        if (($type === 'dosen' || $type === 'staff') && !empty($validated['nik'])) {
            $validated['identifier'] = $validated['nik'];
        }

        if ($type === 'dosen') {
            $validated['nidn'] = null;
        }

        return $validated;
    }
}
