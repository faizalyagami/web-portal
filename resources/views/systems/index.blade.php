@extends('layouts.app')

@section('title', 'Manajemen Sistem')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold" style="color: #1f2937 !important;">Manajemen Sistem</h1>
                <p class="text-sm mt-1" style="color: #9ca3af !important;">
                    Kelola semua sistem yang terhubung ke portal
                </p>
            </div>
            <a href="{{ route('systems.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white transition shadow-md"
                style="background: linear-gradient(135deg, #6B56A5, #56438a) !important;">
                <x-heroicon-o-plus class="w-4 h-4" />
                Tambah Sistem
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 rounded-xl text-sm"
                style="background: rgba(0, 167, 156, 0.08) !important; border: 1px solid rgba(0, 167, 156, 0.25); color: #00847c !important;">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($systems as $system)
                <div class="bg-white rounded-2xl border border-gray-100 p-5 transition hover:shadow-lg"
                    style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">

                    <div class="flex items-start justify-between mb-3">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                            style="background: linear-gradient(135deg, {{ $system->color }}, {{ $system->color }}cc) !important;">
                            <x-dynamic-component :component="'heroicon-o-' . $system->icon" class="w-6 h-6 text-white" />
                        </div>

                        @if ($system->is_active)
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase"
                                style="background: rgba(0, 167, 156, 0.15) !important; color: #00A79C !important;">
                                Aktif
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase"
                                style="background: rgba(107, 114, 128, 0.15) !important; color: #6b7280 !important;">
                                Nonaktif
                            </span>
                        @endif
                    </div>

                    <h3 class="font-bold mb-1" style="color: #1f2937 !important;">{{ $system->name }}</h3>
                    <p class="text-xs line-clamp-2 mb-3" style="color: #9ca3af !important;">
                        {{ $system->description }}
                    </p>

                    <div class="flex flex-wrap gap-1 mb-3">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase"
                            style="background: {{ $system->color }}15 !important; color: {{ $system->color }} !important;">
                            {{ $system->category }}
                        </span>
                        @if (!empty($system->allowed_types))
                            @foreach ($system->allowed_types as $t)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase"
                                    style="background: rgba(107, 114, 128, 0.1) !important; color: #6b7280 !important;">
                                    {{ $t }}
                                </span>
                            @endforeach
                        @endif
                    </div>

                    <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                        <span class="text-xs truncate" style="color: #9ca3af !important;">
                            {{ parse_url($system->url, PHP_URL_HOST) }}
                        </span>
                        <div class="flex gap-1">
                            <a href="{{ route('systems.edit', $system) }}" class="p-1.5 rounded-lg transition"
                                style="color: #6b7280 !important;"
                                onmouseover="this.style.background='rgba(0, 167, 156, 0.1)'; this.style.color='#00A79C';"
                                onmouseout="this.style.background='transparent'; this.style.color='#6b7280';">
                                <x-heroicon-o-pencil-square class="w-4 h-4" />
                            </a>
                            <form method="POST" action="{{ route('systems.destroy', $system) }}"
                                onsubmit="return confirm('Yakin hapus sistem ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg transition"
                                    style="color: #6b7280 !important;"
                                    onmouseover="this.style.background='rgba(239, 68, 68, 0.1)'; this.style.color='#dc2626';"
                                    onmouseout="this.style.background='transparent'; this.style.color='#6b7280';">
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
