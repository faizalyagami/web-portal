@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- ============================================ --}}
        {{-- HERO SECTION --}}
        {{-- ============================================ --}}
        <div class="relative overflow-hidden rounded-3xl p-8 md:p-12 mb-10 shadow-xl"
            style="background: linear-gradient(135deg, #6B56A5 0%, #56438a 60%, #3d2f6b 100%) !important;">

            {{-- Decorative circles --}}
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <svg class="absolute right-0 top-0 h-full w-auto" viewBox="0 0 200 200" fill="white">
                    <circle cx="100" cy="100" r="80" opacity="0.3" />
                    <circle cx="100" cy="100" r="60" opacity="0.4" />
                    <circle cx="100" cy="100" r="40" opacity="0.5" />
                </svg>
            </div>

            <div class="relative z-10">
                {{-- Badges --}}
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold shadow-md"
                        style="background: #F69320 !important; color: #ffffff !important;">
                        <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                        SISTEM TERPADU
                    </div>

                    @php $typeColor = auth()->user()->user_type->badgeColor(); @endphp
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold border border-white/25"
                        style="background: {{ $typeColor }}80 !important; color: #ffffff !important; backdrop-filter: blur(8px);">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ auth()->user()->user_type->label() }}
                    </div>

                    @if (auth()->user()->identifier)
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold border border-white/25"
                            style="background: rgba(255, 255, 255, 0.1) !important; color: #ffffff !important; backdrop-filter: blur(8px);">
                            {{ auth()->user()->identifier_label }}: {{ auth()->user()->identifier }}
                        </div>
                    @endif
                </div>

                {{-- H1 --}}
                <h1 class="text-3xl md:text-5xl font-extrabold mb-3 leading-tight" style="color: #ffffff !important;">
                    Assalamu'alaikum,<br class="md:hidden"> {{ explode(' ', auth()->user()->name)[0] }}! 👋
                </h1>

                {{-- Description --}}
                <p class="text-base md:text-lg max-w-2xl leading-relaxed"
                    style="color: rgba(255, 255, 255, 0.9) !important;">
                    Akses semua sistem informasi Fakultas Psikologi Universitas Islam Bandung dalam satu portal terpadu.
                </p>

                {{-- Stats --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 mt-8">
                    <div class="rounded-2xl p-4 border border-white/20"
                        style="background: rgba(255, 255, 255, 0.1) !important; backdrop-filter: blur(12px);">
                        <div class="text-2xl md:text-3xl font-bold" style="color: #ffffff !important;">
                            {{ $stats['total'] }}
                        </div>
                        <div class="text-xs mt-1" style="color: rgba(255, 255, 255, 0.8) !important;">
                            Total Sistem
                        </div>
                    </div>
                    <div class="rounded-2xl p-4 border border-white/20"
                        style="background: rgba(255, 255, 255, 0.1) !important; backdrop-filter: blur(12px);">
                        <div class="text-2xl md:text-3xl font-bold" style="color: #ffffff !important;">
                            {{ $stats['accessible'] }}
                        </div>
                        <div class="text-xs mt-1" style="color: rgba(255, 255, 255, 0.8) !important;">
                            Akses Anda
                        </div>
                    </div>
                    <div class="rounded-2xl p-4 border border-white/20"
                        style="background: rgba(255, 255, 255, 0.1) !important; backdrop-filter: blur(12px);">
                        <div class="text-2xl md:text-3xl font-bold" style="color: #ffffff !important;">
                            {{ $stats['categories'] }}
                        </div>
                        <div class="text-xs mt-1" style="color: rgba(255, 255, 255, 0.8) !important;">
                            Kategori
                        </div>
                    </div>
                    <div class="rounded-2xl p-4 border border-white/20"
                        style="background: rgba(255, 255, 255, 0.1) !important; backdrop-filter: blur(12px);">
                        <div class="text-2xl md:text-3xl font-bold" style="color: #ffffff !important;">
                            {{ number_format($stats['total_users']) }}
                        </div>
                        <div class="text-xs mt-1" style="color: rgba(255, 255, 255, 0.8) !important;">
                            Total Pengguna
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================ --}}
        {{-- SECTION HEADER --}}
        {{-- ============================================ --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold" style="color: #1f2937 !important;">
                    Daftar Sistem
                </h2>
                <p class="text-sm mt-1" style="color: #9ca3af !important;">
                    Pilih sistem yang ingin Anda akses
                </p>
            </div>

            {{-- Search --}}
            <div class="relative w-full md:w-72">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5" style="color: #9ca3af;" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" id="searchSystem" placeholder="Cari sistem..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm outline-none transition"
                    style="background: #ffffff !important; border: 1.5px solid #e5e7eb; color: #1f2937 !important;"
                    onfocus="this.style.borderColor='#6B56A5'; this.style.boxShadow='0 0 0 4px rgba(107, 86, 165, 0.12)';"
                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
            </div>
        </div>

        {{-- ============================================ --}}
        {{-- FILTER CATEGORY --}}
        {{-- ============================================ --}}
        <div class="flex flex-wrap gap-2 mb-6">
            <button data-filter="all"
                class="filter-btn active px-4 py-2 rounded-full text-sm font-semibold transition shadow-md"
                style="background: linear-gradient(135deg, #6B56A5, #56438a) !important; color: #ffffff !important; border: none;">
                Semua
            </button>
            <button data-filter="akademik" class="filter-btn px-4 py-2 rounded-full text-sm font-medium transition"
                style="background: #ffffff !important; color: #6b7280 !important; border: 1.5px solid #e5e7eb;">
                Akademik
            </button>
            <button data-filter="layanan" class="filter-btn px-4 py-2 rounded-full text-sm font-medium transition"
                style="background: #ffffff !important; color: #6b7280 !important; border: 1.5px solid #e5e7eb;">
                Layanan
            </button>
            <button data-filter="arsip" class="filter-btn px-4 py-2 rounded-full text-sm font-medium transition"
                style="background: #ffffff !important; color: #6b7280 !important; border: 1.5px solid #e5e7eb;">
                Arsip
            </button>
        </div>

        {{-- ============================================ --}}
        {{-- SYSTEM GRID --}}
        {{-- ============================================ --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="systemGrid">
            @foreach ($systems as $system)
                <a href="{{ $system->url }}" target="_blank" data-category="{{ $system->category }}"
                    data-name="{{ strtolower($system->name . ' ' . $system->description) }}"
                    class="system-card group relative bg-white rounded-2xl p-6 border border-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl overflow-hidden"
                    style="background: #ffffff !important; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">

                    {{-- Accent gradient circle --}}
                    <div class="absolute top-0 right-0 w-32 h-32 rounded-full opacity-10 group-hover:opacity-20 transition-opacity -mr-16 -mt-16"
                        style="background: {{ $system->color }}"></div>

                    <div class="relative">
                        {{-- Icon --}}
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4 shadow-md group-hover:scale-110 transition-transform"
                            style="background: linear-gradient(135deg, {{ $system->color }} 0%, {{ $system->color }}cc 100%);">
                            <x-dynamic-component :component="'heroicon-o-' . $system->icon" class="w-7 h-7 text-white" />
                        </div>

                        {{-- Category Badge --}}
                        <span
                            class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider mb-2"
                            style="background: {{ $system->color }}15; color: {{ $system->color }} !important;">
                            {{ $system->category }}
                        </span>

                        {{-- Title --}}
                        <h3 class="text-lg font-bold mb-2 transition group-hover:opacity-80"
                            style="color: #1f2937 !important;">
                            {{ $system->name }}
                        </h3>

                        {{-- Description --}}
                        <p class="text-sm leading-relaxed mb-4 line-clamp-2" style="color: #6b7280 !important;">
                            {{ $system->description }}
                        </p>

                        {{-- Footer --}}
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="text-xs truncate" style="color: #9ca3af !important;">
                                {{ parse_url($system->url, PHP_URL_HOST) }}
                            </span>
                            <span class="flex items-center gap-1 text-sm font-semibold transition-all group-hover:gap-2"
                                style="color: {{ $system->color }} !important;">
                                Buka
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- ============================================ --}}
        {{-- EMPTY STATE --}}
        {{-- ============================================ --}}
        <div id="emptyState" class="hidden text-center py-16">
            <svg class="w-20 h-20 mx-auto mb-4" style="color: #e5e7eb;" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="text-lg font-semibold mb-1" style="color: #1f2937 !important;">
                Sistem tidak ditemukan
            </h3>
            <p class="text-sm" style="color: #9ca3af !important;">
                Coba kata kunci lain atau ubah filter kategori
            </p>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // === Search & Filter ===
        const searchInput = document.getElementById('searchSystem');
        const systemCards = document.querySelectorAll('.system-card');
        const emptyState = document.getElementById('emptyState');
        const filterBtns = document.querySelectorAll('.filter-btn');
        let currentFilter = 'all';

        function filterSystems() {
            const query = searchInput.value.toLowerCase();
            let visibleCount = 0;

            systemCards.forEach(card => {
                const matchesSearch = card.dataset.name.includes(query);
                const matchesFilter = currentFilter === 'all' || card.dataset.category === currentFilter;
                const isVisible = matchesSearch && matchesFilter;

                card.style.display = isVisible ? '' : 'none';
                if (isVisible) visibleCount++;
            });

            emptyState.classList.toggle('hidden', visibleCount > 0);
        }

        searchInput?.addEventListener('input', filterSystems);

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Reset semua button ke inactive
                filterBtns.forEach(b => {
                    b.style.background = '#ffffff';
                    b.style.color = '#6b7280';
                    b.style.border = '1.5px solid #e5e7eb';
                    b.style.boxShadow = 'none';
                    b.classList.remove('active');
                });

                // Set button yang diklik jadi active
                btn.style.background = 'linear-gradient(135deg, #6B56A5, #56438a)';
                btn.style.color = '#ffffff';
                btn.style.border = 'none';
                btn.style.boxShadow = '0 4px 12px rgba(107, 86, 165, 0.25)';
                btn.classList.add('active');

                currentFilter = btn.dataset.filter;
                filterSystems();
            });
        });
    </script>
@endpush
