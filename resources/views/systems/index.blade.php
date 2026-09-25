@extends('layouts.app')

@section('title', 'Manajemen Sistem')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Manajemen Sistem</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola semua sistem yang terhubung ke portal</p>
            </div>
            <a href="{{ route('systems.create') }}">
                <x-button icon="plus">Tambah Sistem</x-button>
            </a>
        </div>

        @if (session('success'))
            <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
        @endif

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($systems as $system)
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 hover:shadow-lg transition">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                            style="background: linear-gradient(135deg, {{ $system->color }}, {{ $system->color }}cc)">
                            <x-dynamic-component :component="'heroicon-o-' . $system->icon" class="w-6 h-6 text-white" />
                        </div>
                        <div class="flex gap-1">
                            @if ($system->is_active)
                                <x-badge color="#16a34a" size="sm">Aktif</x-badge>
                            @else
                                <x-badge color="#6b7280" size="sm">Nonaktif</x-badge>
                            @endif
                        </div>
                    </div>

                    <h3 class="font-bold text-gray-800 dark:text-white mb-1">{{ $system->name }}</h3>
                    <p class="text-xs text-gray-500 line-clamp-2 mb-3">{{ $system->description }}</p>

                    <div class="flex flex-wrap gap-1 mb-3">
                        <x-badge :color="$system->color" size="sm">{{ $system->category }}</x-badge>
                        @if (!empty($system->allowed_types))
                            @foreach ($system->allowed_types as $t)
                                <x-badge color="#6b7280" size="sm">{{ $t }}</x-badge>
                            @endforeach
                        @endif
                    </div>

                    <div class="flex justify-between items-center pt-3 border-t border-gray-100 dark:border-gray-700">
                        <span class="text-xs text-gray-400 truncate">{{ parse_url($system->url, PHP_URL_HOST) }}</span>
                        <div class="flex gap-1">
                            <a href="{{ route('systems.edit', $system) }}"
                                class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-blue-500">
                                <x-heroicon-o-pencil-square class="w-4 h-4" />
                            </a>
                            <form method="POST" action="{{ route('systems.destroy', $system) }}"
                                onsubmit="return confirm('Yakin hapus sistem ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="p-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 text-red-500">
                                    <x-heroicon-o-trash class="w-4 h-4" />
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
