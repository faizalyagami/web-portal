@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('users.index') }}"
                class="text-sm text-gray-500 hover:text-[#0d7a3f] flex items-center gap-1 mb-2">
                <x-heroicon-o-arrow-left class="w-4 h-4" /> Kembali
            </a>
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Detail User</h1>
                <div class="flex gap-2">
                    <a href="{{ route('users.access', $user) }}">
                        <x-button variant="secondary" icon="key">Akses Sistem</x-button>
                    </a>
                    <a href="{{ route('users.edit', $user) }}">
                        <x-button icon="pencil-square">Edit</x-button>
                    </a>
                </div>
            </div>
        </div>

        <x-card>
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <div
                    class="w-20 h-20 rounded-2xl unisba-gradient flex items-center justify-center text-white text-2xl font-bold flex-shrink-0">
                    {{ $user->initials }}
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>

                    <div class="flex flex-wrap gap-2 justify-center md:justify-start mt-3">
                        <x-badge :color="$user->user_type->badgeColor()">{{ $user->user_type->label() }}</x-badge>
                        @if ($user->is_active)
                            <x-badge color="#16a34a">Aktif</x-badge>
                        @else
                            <x-badge color="#6b7280">Nonaktif</x-badge>
                        @endif
                        @if ($user->is_super_admin)
                            <x-badge color="#8b5cf6">Super Admin</x-badge>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                @php
                    $rows = [
                        'Identifier' => $user->identifier,
                        'NIDN' => $user->nidn,
                        'NIK' => $user->nik,
                        'Fakultas' => $user->fakultas,
                        'Program Studi' => $user->program_studi,
                        'Jabatan' => $user->jabatan,
                        'Angkatan' => $user->angkatan,
                        'No. Telepon' => $user->phone,
                        'Login Terakhir' => $user->last_login_at?->diffForHumans(),
                        'Terdaftar' => $user->created_at->format('d M Y'),
                    ];
                @endphp
                @foreach ($rows as $label => $value)
                    @if ($value)
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wide">{{ $label }}</div>
                            <div class="text-sm font-medium text-gray-800 dark:text-white mt-0.5">{{ $value }}</div>
                        </div>
                    @endif
                @endforeach
            </div>
        </x-card>

        @if ($user->systems->isNotEmpty())
            <x-card title="Akses Sistem" class="mt-6">
                <div class="flex flex-wrap gap-2">
                    @foreach ($user->systems as $s)
                        <div class="px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 text-sm flex items-center gap-2">
                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ $s->name }}</span>
                            <x-badge :color="$s->color" size="sm">{{ $s->pivot->role }}</x-badge>
                        </div>
                    @endforeach
                </div>
            </x-card>
        @endif
    </div>
@endsection
