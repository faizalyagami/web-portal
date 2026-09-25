<?php

namespace App\Http\Controllers;

use App\Models\System;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SystemManagementController extends Controller
{
    public function index(): View
    {
        return view('systems.index', [
            'systems' => System::orderBy('order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('systems.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateSystem($request);
        System::create($validated);

        return redirect()->route('systems.index')
            ->with('success', 'Sistem berhasil ditambahkan.');
    }

    public function edit(System $system): View
    {
        return view('systems.edit', compact('system'));
    }

    public function update(Request $request, System $system): RedirectResponse
    {
        $validated = $this->validateSystem($request, $system->id);
        $system->update($validated);

        return redirect()->route('systems.index')
            ->with('success', 'Sistem berhasil diperbarui.');
    }

    public function destroy(System $system): RedirectResponse
    {
        $system->delete();

        return redirect()->route('systems.index')
            ->with('success', 'Sistem berhasil dihapus.');
    }

    public function toggleActive(System $system): RedirectResponse
    {
        $system->update(['is_active' => !$system->is_active]);

        return back()->with('success', 'Status sistem berhasil diubah.');
    }

    protected function validateSystem(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => [
                'required',
                'string',
                'max:100',
                Rule::unique('systems', 'slug')->ignore($ignoreId)
            ],
            'url' => ['required', 'url', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'icon' => ['required', 'string', 'max:50'],
            'color' => ['required', 'string', 'max:7'],
            'category' => ['required', 'string', 'max:50'],
            'allowed_types' => ['nullable', 'array'],
            'allowed_types.*' => ['string'],
            'is_active' => ['boolean'],
            'order' => ['nullable', 'integer'],
        ]);
    }
}
