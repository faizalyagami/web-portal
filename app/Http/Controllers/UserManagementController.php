<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Models\ActivityLog;
use App\Models\System;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

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
        $validated['password'] = Hash::make($request->password ?? 'password123');
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
            $validated['password'] = Hash::make($request->password);
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
        $user->update(['password' => Hash::make($newPassword)]);

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

    public function import(Request $request): RedirectResponse
    {
        // Placeholder - implementasi dengan Laravel Excel
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
            'user_type' => ['required', Rule::enum(UserType::class)],
        ]);

        // TODO: Implementasi dengan maatwebsite/excel
        return back()->with('success', 'Import berhasil diproses.');
    }

    public function downloadTemplate(Request $request)
    {
        $type = $request->input('type', 'mahasiswa');

        // Tentukan kolom sesuai tipe user
        $columns = match ($type) {
            'mahasiswa' => ['name', 'email', 'identifier', 'fakultas', 'program_studi', 'angkatan'],
            'dosen'     => ['name', 'email', 'nidn', 'fakultas', 'program_studi', 'jabatan'],
            'staff'     => ['name', 'email', 'nik', 'fakultas', 'jabatan'],
            'admin'     => ['name', 'email', 'identifier', 'jabatan'],
            default     => ['name', 'email', 'identifier', 'fakultas', 'program_studi', 'jabatan'],
        };

        // Contoh data
        $example = match ($type) {
            'mahasiswa' => ['Ahmad Fauzi', 'ahmad.fauzi@student.unisba.ac.id', '10012345', 'Psikologi', 'Psikologi', '2021'],
            'dosen'     => ['Dr. Rina Marlina, M.Psi.', 'rina.marlina@unisba.ac.id', '0412345678', 'Psikologi', 'Psikologi', 'Lektor Kepala'],
            'staff'     => ['Dewi Lestari, S.Kom.', 'dewi.lestari@unisba.ac.id', '3273012345670001', 'Psikologi', 'Staf Akademik'],
            'admin'     => ['Administrator', 'admin@unisba.ac.id', 'ADMIN-001', 'Kepala PSITEK'],
            default     => ['Nama Lengkap', 'email@unisba.ac.id', '12345678', 'Psikologi', 'Psikologi', 'Jabatan'],
        };

        // Nama file
        $filename = "template-import-{$type}-" . date('Y-m-d') . ".csv";

        // Header untuk download
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        // Callback untuk generate CSV
        $callback = function () use ($columns, $example) {
            $file = fopen('php://output', 'w');

            // Tambahkan BOM agar Excel bisa baca UTF-8 dengan benar
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Baris header
            fputcsv($file, $columns, ';');

            // Baris contoh data
            fputcsv($file, $example, ';');

            // Baris kosong (untuk user mengisi data di bawahnya)
            fputcsv($file, array_fill(0, count($columns), ''), ';');

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
        if ($type === 'dosen' && !empty($validated['nidn'])) {
            $validated['identifier'] = $validated['nidn'];
        } elseif ($type === 'staff' && !empty($validated['nik'])) {
            $validated['identifier'] = $validated['nik'];
        }

        return $validated;
    }
}
