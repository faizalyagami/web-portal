@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- ============================================ --}}
        {{-- HEADER --}}
        {{-- ============================================ --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold" style="color: #1f2937 !important;">Manajemen User</h1>
                <p class="text-sm mt-1" style="color: #9ca3af !important;">Kelola seluruh pengguna portal</p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('users.import.form') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition"
                    style="background: #ffffff !important; color: #6B56A5 !important; border: 1.5px solid rgba(107, 86, 165, 0.3);"
                    onmouseover="this.style.background='rgba(107, 86, 165, 0.06)'"
                    onmouseout="this.style.background='#ffffff'">
                    <x-heroicon-o-arrow-up-tray class="w-4 h-4" />
                    Import
                </a>

                <a href="{{ route('users.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white transition shadow-md"
                    style="background: linear-gradient(135deg, #6B56A5, #56438a) !important;"
                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 10px 24px rgba(107, 86, 165, 0.35)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(107, 86, 165, 0.2)';">
                    <x-heroicon-o-plus class="w-4 h-4" />
                    Tambah User
                </a>
            </div>
        </div>

        {{-- ============================================ --}}
        {{-- ALERTS --}}
        {{-- ============================================ --}}
        @if (session('success'))
            <div class="mb-4 p-4 rounded-xl text-sm flex items-start gap-3"
                style="background: rgba(0, 167, 156, 0.08) !important; border: 1px solid rgba(0, 167, 156, 0.25); color: #00847c !important;">
                <x-heroicon-o-check-circle class="w-5 h-5 flex-shrink-0 mt-0.5" />
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 rounded-xl text-sm flex items-start gap-3"
                style="background: rgba(239, 68, 68, 0.08) !important; border: 1px solid rgba(239, 68, 68, 0.25); color: #dc2626 !important;">
                <x-heroicon-o-x-circle class="w-5 h-5 flex-shrink-0 mt-0.5" />
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- ============================================ --}}
        {{-- STATISTIK --}}
        {{-- ============================================ --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3 md:gap-4 mb-6">

            {{-- Total User --}}
            <div class="bg-white rounded-2xl p-4 border border-gray-100"
                style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-2xl md:text-3xl font-bold" style="color: #1f2937 !important;">
                        {{ $stats['total'] }}
                    </div>
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                        style="background: rgba(107, 86, 165, 0.1) !important;">
                        <x-heroicon-o-users class="w-4 h-4" style="color: #6B56A5 !important;" />
                    </div>
                </div>
                <div class="text-xs font-medium" style="color: #9ca3af !important;">Total User</div>
            </div>

            {{-- Mahasiswa --}}
            <div class="bg-white rounded-2xl p-4 border border-gray-100"
                style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-2xl md:text-3xl font-bold" style="color: #00A79C !important;">
                        {{ $stats['mahasiswa'] }}
                    </div>
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                        style="background: rgba(0, 167, 156, 0.1) !important;">
                        <x-heroicon-o-academic-cap class="w-4 h-4" style="color: #00A79C !important;" />
                    </div>
                </div>
                <div class="text-xs font-medium" style="color: #9ca3af !important;">Mahasiswa</div>
            </div>

            {{-- Dosen --}}
            <div class="bg-white rounded-2xl p-4 border border-gray-100"
                style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-2xl md:text-3xl font-bold" style="color: #6B56A5 !important;">
                        {{ $stats['dosen'] }}
                    </div>
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                        style="background: rgba(107, 86, 165, 0.1) !important;">
                        <x-heroicon-o-user-circle class="w-4 h-4" style="color: #6B56A5 !important;" />
                    </div>
                </div>
                <div class="text-xs font-medium" style="color: #9ca3af !important;">Dosen</div>
            </div>

            {{-- Staff --}}
            <div class="bg-white rounded-2xl p-4 border border-gray-100"
                style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-2xl md:text-3xl font-bold" style="color: #F69320 !important;">
                        {{ $stats['staff'] }}
                    </div>
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                        style="background: rgba(246, 147, 32, 0.1) !important;">
                        <x-heroicon-o-briefcase class="w-4 h-4" style="color: #F69320 !important;" />
                    </div>
                </div>
                <div class="text-xs font-medium" style="color: #9ca3af !important;">Staff</div>
            </div>

            {{-- Admin --}}
            <div class="bg-white rounded-2xl p-4 border border-gray-100"
                style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-2xl md:text-3xl font-bold" style="color: #56438a !important;">
                        {{ $stats['admin'] }}
                    </div>
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center"
                        style="background: rgba(86, 67, 138, 0.1) !important;">
                        <x-heroicon-o-shield-check class="w-4 h-4" style="color: #56438a !important;" />
                    </div>
                </div>
                <div class="text-xs font-medium" style="color: #9ca3af !important;">Admin</div>
            </div>
        </div>

        {{-- ============================================ --}}
        {{-- FILTER --}}
        {{-- ============================================ --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-4 mb-4"
            style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">
            <form method="GET" class="grid md:grid-cols-4 gap-3">

                {{-- Search --}}
                <div class="md:col-span-2 relative">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"
                        style="color: #9ca3af !important;">
                        <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama, email, atau NPM/NIDN/NIK..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm outline-none transition"
                        style="background: #ffffff !important; border: 1.5px solid #e5e7eb; color: #1f2937 !important;"
                        onfocus="this.style.borderColor='#6B56A5'; this.style.boxShadow='0 0 0 4px rgba(107, 86, 165, 0.12)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>

                {{-- Tipe --}}
                <select name="type" class="px-4 py-2.5 rounded-xl text-sm outline-none transition appearance-none"
                    style="background: #ffffff !important; border: 1.5px solid #e5e7eb; color: #1f2937 !important;"
                    onfocus="this.style.borderColor='#6B56A5'; this.style.boxShadow='0 0 0 4px rgba(107, 86, 165, 0.12)';"
                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    <option value="">Semua Tipe</option>
                    @foreach ($types as $t)
                        <option value="{{ $t->value }}" {{ request('type') == $t->value ? 'selected' : '' }}>
                            {{ $t->label() }}
                        </option>
                    @endforeach
                </select>

                {{-- Status --}}
                <select name="status" class="px-4 py-2.5 rounded-xl text-sm outline-none transition appearance-none"
                    style="background: #ffffff !important; border: 1.5px solid #e5e7eb; color: #1f2937 !important;"
                    onfocus="this.style.borderColor='#6B56A5'; this.style.boxShadow='0 0 0 4px rgba(107, 86, 165, 0.12)';"
                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </form>
        </div>

        {{-- ============================================ --}}
        {{-- TABLE --}}
        {{-- ============================================ --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
            style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">

            <div class="overflow-x-auto">
                <table class="w-full">
                    {{-- Head --}}
                    <thead>
                        <tr style="background: #f9fafb !important; border-bottom: 1px solid #e5e7eb;">
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider"
                                style="color: #6b7280 !important;">User</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider"
                                style="color: #6b7280 !important;">Identifier</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider"
                                style="color: #6b7280 !important;">Tipe</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider"
                                style="color: #6b7280 !important;">Fakultas</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wider"
                                style="color: #6b7280 !important;">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-bold uppercase tracking-wider"
                                style="color: #6b7280 !important;">Aksi</th>
                        </tr>
                    </thead>

                    {{-- Body --}}
                    <tbody>
                        @forelse($users as $user)
                            @php
                                $typeStyles = [
                                    'mahasiswa' => ['color' => '#00A79C', 'label' => 'Mahasiswa'],
                                    'dosen' => ['color' => '#6B56A5', 'label' => 'Dosen'],
                                    'staff' => ['color' => '#F69320', 'label' => 'Staff / Tenaga Kependidikan'],
                                    'admin' => ['color' => '#56438a', 'label' => 'Administrator'],
                                ];
                                $type = $typeStyles[$user->user_type->value] ?? [
                                    'color' => '#6b7280',
                                    'label' => $user->user_type->label(),
                                ];
                            @endphp

                            <tr class="border-b border-gray-100 transition" onmouseover="this.style.background='#f9fafb'"
                                onmouseout="this.style.background='transparent'">

                                {{-- User --}}
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-xs flex-shrink-0 shadow-sm"
                                            style="background: linear-gradient(135deg, #6B56A5, #56438a) !important;">
                                            {{ $user->initials }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-semibold text-sm truncate"
                                                style="color: #1f2937 !important;">
                                                {{ $user->name }}
                                            </div>
                                            <div class="text-xs truncate" style="color: #9ca3af !important;">
                                                {{ $user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Identifier --}}
                                <td class="px-4 py-4">
                                    <span class="text-sm font-mono" style="color: #1f2937 !important;">
                                        {{ $user->identifier ?? '—' }}
                                    </span>
                                </td>

                                {{-- Tipe --}}
                                <td class="px-4 py-4">
                                    <span
                                        class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide"
                                        style="background: {{ $type['color'] }}15 !important; color: {{ $type['color'] }} !important;">
                                        {{ $type['label'] }}
                                    </span>
                                </td>

                                {{-- Fakultas --}}
                                <td class="px-4 py-4 text-sm" style="color: #6b7280 !important;">
                                    {{ $user->fakultas ?? '—' }}
                                </td>

                                {{-- Status --}}
                                <td class="px-4 py-4">
                                    @if ($user->is_active)
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold"
                                            style="color: #00A79C !important;">
                                            <span class="w-2 h-2 rounded-full"
                                                style="background: #00A79C !important;"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold"
                                            style="color: #9ca3af !important;">
                                            <span class="w-2 h-2 rounded-full"
                                                style="background: #9ca3af !important;"></span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-end gap-1" x-data="{ open: false }">

                                        {{-- View --}}
                                        <a href="{{ route('users.show', $user) }}" class="p-2 rounded-lg transition"
                                            title="Lihat Detail" style="color: #6b7280 !important;"
                                            onmouseover="this.style.background='rgba(107, 86, 165, 0.1)'; this.style.color='#6B56A5';"
                                            onmouseout="this.style.background='transparent'; this.style.color='#6b7280';">
                                            <x-heroicon-o-eye class="w-4 h-4" />
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('users.edit', $user) }}" class="p-2 rounded-lg transition"
                                            title="Edit" style="color: #6b7280 !important;"
                                            onmouseover="this.style.background='rgba(0, 167, 156, 0.1)'; this.style.color='#00A79C';"
                                            onmouseout="this.style.background='transparent'; this.style.color='#6b7280';">
                                            <x-heroicon-o-pencil-square class="w-4 h-4" />
                                        </a>

                                        {{-- Access --}}
                                        <a href="{{ route('users.access', $user) }}" class="p-2 rounded-lg transition"
                                            title="Kelola Akses" style="color: #6b7280 !important;"
                                            onmouseover="this.style.background='rgba(246, 147, 32, 0.1)'; this.style.color='#F69320';"
                                            onmouseout="this.style.background='transparent'; this.style.color='#6b7280';">
                                            <x-heroicon-o-key class="w-4 h-4" />
                                        </a>

                                        {{-- More --}}
                                        <div class="relative">
                                            <button @click="open = !open" class="p-2 rounded-lg transition"
                                                style="color: #6b7280 !important;"
                                                onmouseover="this.style.background='#f3f4f6'"
                                                onmouseout="this.style.background='transparent'">
                                                <x-heroicon-o-ellipsis-vertical class="w-4 h-4" />
                                            </button>

                                            <div x-show="open" @click.away="open = false" x-transition x-cloak
                                                class="absolute right-0 mt-2 w-48 rounded-xl shadow-xl border border-gray-100 overflow-hidden z-20"
                                                style="background: #ffffff !important;">

                                                {{-- Toggle Active --}}
                                                <form method="POST" action="{{ route('users.toggle-active', $user) }}">
                                                    @csrf @method('PATCH')
                                                    <button type="submit"
                                                        class="w-full text-left px-4 py-2.5 text-sm transition flex items-center gap-2"
                                                        style="color: #1f2937 !important;"
                                                        onmouseover="this.style.background='#f9fafb'"
                                                        onmouseout="this.style.background='transparent'">
                                                        <x-heroicon-o-power class="w-4 h-4" />
                                                        {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                    </button>
                                                </form>

                                                {{-- Reset Password --}}
                                                <form method="POST" action="{{ route('users.reset-password', $user) }}">
                                                    @csrf
                                                    <button type="submit"
                                                        class="w-full text-left px-4 py-2.5 text-sm transition flex items-center gap-2"
                                                        style="color: #1f2937 !important;"
                                                        onmouseover="this.style.background='#f9fafb'"
                                                        onmouseout="this.style.background='transparent'">
                                                        <x-heroicon-o-arrow-path class="w-4 h-4" />
                                                        Reset Password
                                                    </button>
                                                </form>

                                                {{-- Delete --}}
                                                @if ($user->id !== auth()->id())
                                                    <div class="border-t border-gray-100">
                                                        <form method="POST" action="{{ route('users.destroy', $user) }}"
                                                            onsubmit="return confirm('Yakin hapus user ini? Tindakan tidak dapat dibatalkan.')">
                                                            @csrf @method('DELETE')
                                                            <button type="submit"
                                                                class="w-full text-left px-4 py-2.5 text-sm transition flex items-center gap-2"
                                                                style="color: #dc2626 !important;"
                                                                onmouseover="this.style.background='rgba(239, 68, 68, 0.08)'"
                                                                onmouseout="this.style.background='transparent'">
                                                                <x-heroicon-o-trash class="w-4 h-4" />
                                                                Hapus User
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-3"
                                            style="background: rgba(107, 86, 165, 0.08) !important;">
                                            <x-heroicon-o-users class="w-8 h-8" style="color: #6B56A5 !important;" />
                                        </div>
                                        <h3 class="text-base font-bold mb-1" style="color: #1f2937 !important;">
                                            Tidak ada user ditemukan
                                        </h3>
                                        <p class="text-sm" style="color: #9ca3af !important;">
                                            Coba ubah filter atau tambahkan user baru
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($users->hasPages())
                <div class="px-4 py-3 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
