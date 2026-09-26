@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold" style="color: #1f2937 !important;">Log Aktivitas</h1>
            <p class="text-sm mt-1" style="color: #9ca3af !important;">
                Riwayat semua aksi yang dilakukan di portal
            </p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-2xl p-4 border border-gray-100"
                style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">
                <div class="text-2xl font-bold" style="color: #1f2937 !important;">{{ $stats['total'] }}</div>
                <div class="text-xs mt-1" style="color: #9ca3af !important;">Total Aktivitas</div>
            </div>
            <div class="bg-white rounded-2xl p-4 border border-gray-100"
                style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">
                <div class="text-2xl font-bold" style="color: #6B56A5 !important;">{{ $stats['today'] }}</div>
                <div class="text-xs mt-1" style="color: #9ca3af !important;">Hari Ini</div>
            </div>
            <div class="bg-white rounded-2xl p-4 border border-gray-100"
                style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">
                <div class="text-2xl font-bold" style="color: #00A79C !important;">{{ $stats['week'] }}</div>
                <div class="text-xs mt-1" style="color: #9ca3af !important;">Minggu Ini</div>
            </div>
        </div>

        {{-- Filter --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-4 mb-4"
            style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">
            <form method="GET" class="grid md:grid-cols-3 gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari deskripsi..."
                    class="px-4 py-2.5 rounded-xl text-sm outline-none transition"
                    style="background: #ffffff !important; border: 1.5px solid #e5e7eb; color: #1f2937 !important;"
                    onfocus="this.style.borderColor='#6B56A5'; this.style.boxShadow='0 0 0 4px rgba(107, 86, 165, 0.12)';"
                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">

                <select name="action" class="px-4 py-2.5 rounded-xl text-sm outline-none transition"
                    style="background: #ffffff !important; border: 1.5px solid #e5e7eb; color: #1f2937 !important;">
                    <option value="">Semua Aksi</option>
                    @foreach ($actions as $a)
                        <option value="{{ $a }}" {{ request('action') == $a ? 'selected' : '' }}>
                            {{ ucfirst($a) }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="px-4 py-2.5 rounded-xl text-white font-semibold text-sm transition shadow-md"
                    style="background: linear-gradient(135deg, #6B56A5, #56438a) !important;">
                    Filter
                </button>
            </form>
        </div>

        {{-- Log List --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
            style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">
            <div>
                @forelse($logs as $log)
                    <div class="p-4 transition flex items-start gap-4 border-b border-gray-100"
                        onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">

                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                            style="background: {{ $log->action_color }}20 !important;">
                            <x-dynamic-component :component="'heroicon-o-' . $log->action_icon" class="w-5 h-5"
                                style="color: {{ $log->action_color }} !important;" />
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1 flex-wrap">
                                <span class="font-semibold text-sm" style="color: #1f2937 !important;">
                                    {{ $log->user->name ?? 'System' }}
                                </span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase"
                                    style="background: {{ $log->action_color }}20 !important; color: {{ $log->action_color }} !important;">
                                    {{ $log->action }}
                                </span>
                            </div>
                            <p class="text-sm" style="color: #6b7280 !important;">{{ $log->description }}</p>
                            <div class="text-xs mt-1" style="color: #9ca3af !important;">
                                {{ $log->created_at->diffForHumans() }}
                                · {{ $log->created_at->format('d M Y H:i') }}
                                @if ($log->ip_address)
                                    · IP: {{ $log->ip_address }}
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <x-heroicon-o-clipboard-document-list class="w-12 h-12 mx-auto mb-2"
                            style="color: #e5e7eb !important;" />
                        <p class="text-sm" style="color: #9ca3af !important;">Belum ada aktivitas tercatat</p>
                    </div>
                @endforelse
            </div>

            @if ($logs->hasPages())
                <div class="px-4 py-3 border-t border-gray-100">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
