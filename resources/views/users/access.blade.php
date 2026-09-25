@extends('layouts.app')

@section('title', 'Kelola Akses')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('users.show', $user) }}"
                class="text-sm text-gray-500 hover:text-[#0d7a3f] flex items-center gap-1 mb-2">
                <x-heroicon-o-arrow-left class="w-4 h-4" /> Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Kelola Akses Sistem</h1>
            <p class="text-sm text-gray-500 mt-1">
                Atur hak akses <span class="font-semibold">{{ $user->name }}</span> ke setiap sistem
            </p>
        </div>

        <form method="POST" action="{{ route('users.access.update', $user) }}">
            @csrf

            <x-card>
                <div class="space-y-3">
                    @foreach ($systems as $system)
                        @php
                            $currentRole = $userAccess[$system->id] ?? '';
                        @endphp

                        <div
                            class="flex items-center gap-4 p-3 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-[#0d7a3f] transition">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0"
                                style="background: {{ $system->color }}20">
                                <x-dynamic-component :component="'heroicon-o-' . $system->icon" class="w-5 h-5"
                                    style="color: {{ $system->color }}" />
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-sm text-gray-800 dark:text-white">{{ $system->name }}</div>
                                <div class="text-xs text-gray-500 truncate">{{ $system->description }}</div>
                            </div>

                            <select name="access[{{ $system->id }}]"
                                class="px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm focus:ring-2 focus:ring-[#0d7a3f] outline-none">
                                <option value="">Tidak Ada</option>
                                <option value="viewer" {{ $currentRole === 'viewer' ? 'selected' : '' }}>Viewer</option>
                                <option value="operator" {{ $currentRole === 'operator' ? 'selected' : '' }}>Operator
                                </option>
                                <option value="admin" {{ $currentRole === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                    @endforeach
                </div>
            </x-card>

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('users.show', $user) }}">
                    <x-button variant="secondary">Batal</x-button>
                </a>
                <x-button type="submit" icon="check">Simpan Akses</x-button>
            </div>
        </form>
    </div>
@endsection
