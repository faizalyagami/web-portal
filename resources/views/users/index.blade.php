@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Manajemen User</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola seluruh pengguna portal</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('users.import.form') }}">
                    <x-button variant="secondary" icon="arrow-up-tray">Import</x-button>
                </a>
                <a href="{{ route('users.create') }}">
                    <x-button icon="plus">Tambah User</x-button>
                </a>
            </div>
        </div>

        @if (session('success'))
            <x-alert type="success" class="mb-4">{{ session('success') }}</x-alert>
        @endif
        @if (session('error'))
            <x-alert type="error" class="mb-4">{{ session('error') }}</x-alert>
        @endif

        {{-- Statistik --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700">
                <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['total'] }}</div>
                <div class="text-xs text-gray-500 mt-1">Total User</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700">
                <div class="text-2xl font-bold text-sky-600">{{ $stats['mahasiswa'] }}</div>
                <div class="text-xs text-gray-500 mt-1">Mahasiswa</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700">
                <div class="text-2xl font-bold text-[#0d7a3f]">{{ $stats['dosen'] }}</div>
                <div class="text-xs text-gray-500 mt-1">Dosen</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700">
                <div class="text-2xl font-bold text-amber-500">{{ $stats['staff'] }}</div>
                <div class="text-xs text-gray-500 mt-1">Staff</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700">
                <div class="text-2xl font-bold text-purple-600">{{ $stats['admin'] }}</div>
                <div class="text-xs text-gray-500 mt-1">Admin</div>
            </div>
        </div>

        {{-- Filter --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-4 mb-4">
            <form method="GET" class="grid md:grid-cols-4 gap-3">
                <div class="md:col-span-2">
                    <x-input name="search" placeholder="Cari nama, email, atau NPM/NIDN/NIK..." :value="request('search')"
                        icon="magnifying-glass" />
                </div>
                <x-select name="type" :value="request('type')" placeholder="Semua Tipe" :options="collect($types)->mapWithKeys(fn($t) => [$t->value => $t->label()])->toArray()" />
                <x-select name="status" :value="request('status')" placeholder="Semua Status" :options="['active' => 'Aktif', 'inactive' => 'Nonaktif']" />
            </form>
        </div>

        {{-- Tabel --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">User</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Identifier</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tipe</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Fakultas</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-full unisba-gradient flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                                            {{ $user->initials }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-semibold text-sm text-gray-800 dark:text-white truncate">
                                                {{ $user->name }}
                                            </div>
                                            <div class="text-xs text-gray-500 truncate">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                    {{ $user->identifier ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <x-badge :color="$user->user_type->badgeColor()" size="sm">
                                        {{ $user->user_type->label() }}
                                    </x-badge>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                    {{ $user->fakultas ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($user->is_active)
                                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-600">
                                            <span class="w-2 h-2 rounded-full bg-green-500"></span> Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-gray-400">
                                            <span class="w-2 h-2 rounded-full bg-gray-400"></span> Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-1" x-data="{ open: false }">
                                        <a href="{{ route('users.show', $user) }}"
                                            class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-500"
                                            title="Lihat">
                                            <x-heroicon-o-eye class="w-4 h-4" />
                                        </a>
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-blue-500"
                                            title="Edit">
                                            <x-heroicon-o-pencil-square class="w-4 h-4" />
                                        </a>
                                        <a href="{{ route('users.access', $user) }}"
                                            class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-purple-500"
                                            title="Akses Sistem">
                                            <x-heroicon-o-key class="w-4 h-4" />
                                        </a>
                                        <div class="relative">
                                            <button @click="open = !open"
                                                class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-500">
                                                <x-heroicon-o-ellipsis-vertical class="w-4 h-4" />
                                            </button>
                                            <div x-show="open" @click.away="open = false" x-transition
                                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden z-10">
                                                <form method="POST" action="{{ route('users.toggle-active', $user) }}">
                                                    @csrf @method('PATCH')
                                                    <button type="submit"
                                                        class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('users.reset-password', $user) }}">
                                                    @csrf
                                                    <button type="submit"
                                                        class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        Reset Password
                                                    </button>
                                                </form>
                                                @if ($user->id !== auth()->id())
                                                    <form method="POST" action="{{ route('users.destroy', $user) }}"
                                                        onsubmit="return confirm('Yakin hapus user ini?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center text-gray-500">
                                    <x-heroicon-o-users class="w-12 h-12 mx-auto text-gray-300 mb-2" />
                                    Tidak ada user ditemukan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
