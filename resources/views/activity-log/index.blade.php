@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Log Aktivitas</h1>
            <p class="text-sm text-gray-500 mt-1">Riwayat semua aksi yang dilakukan di portal</p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700">
                <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['total'] }}</div>
                <div class="text-xs text-gray-500 mt-1">Total Aktivitas</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700">
                <div class="text-2xl font-bold text-[#0d7a3f]">{{ $stats['today'] }}</div>
                <div class="text-xs text-gray-500 mt-1">Hari Ini</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700">
                <div class="text-2xl font-bold text-blue-600">{{ $stats['week'] }}</div>
                <div class="text-xs text-gray-500 mt-1">Minggu Ini</div>
            </div>
        </div>

        {{-- Filter --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-4 mb-4">
            <form method="GET" class="grid md:grid-cols-3 gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari deskripsi..."
                    class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                <select name="action"
                    class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm">
                    <option value="">Semua Aksi</option>
                    @foreach ($actions as $a)
                        <option value="{{ $a }}" {{ request('action') == $a ? 'selected' : '' }}>
                            {{ ucfirst($a) }}
                        </option>
                    @endforeach
                </select>
                <button type="submit"
                    class="px-4 py-2.5 rounded-xl bg-[#0d7a3f] text-white font-semibold text-sm hover:bg-[#085c2d]">
                    Filter
                </button>
            </form>
        </div>

        {{-- Log List --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($logs as $log)
                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                            style="background: {{ $log->action_color }}20;">
                            <x-dynamic-component :component="'heroicon-o-' . $log->action_icon" class="w-5 h-5"
                                style="color: {{ $log->action_color }}" />
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1 flex-wrap">
                                <span class="font-semibold text-sm text-gray-800 dark:text-white">
                                    {{ $log->user->name ?? 'System' }}
                                </span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase"
                                    style="background: {{ $log->action_color }}20; color: {{ $log->action_color }};">
                                    {{ $log->action }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $log->description }}</p>
                            <div class="text-xs text-gray-400 mt-1">
                                {{ $log->created_at->diffForHumans() }}
                                · {{ $log->created_at->format('d M Y H:i') }}
                                @if ($log->ip_address)
                                    · IP: {{ $log->ip_address }}
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center text-gray-500">
                        <x-heroicon-o-clipboard-document-list class="w-12 h-12 mx-auto text-gray-300 mb-2" />
                        Belum ada aktivitas tercatat
                    </div>
                @endforelse
            </div>

            @if ($logs->hasPages())
                <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
