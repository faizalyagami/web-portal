@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-6">
            <a href="{{ route('users.index') }}" class="inline-flex items-center gap-1 text-sm font-medium mb-3 transition"
                style="color: #6b7280 !important;">
                <x-heroicon-o-arrow-left class="w-4 h-4" />
                Kembali
            </a>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <h1 class="text-2xl font-bold" style="color: #1f2937 !important;">Detail User</h1>
                <div class="flex gap-2">
                    <a href="{{ route('users.access', $user) }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition"
                        style="background: #ffffff !important; color: #6b7280 !important; border: 1.5px solid #e5e7eb !important;">
                        <x-heroicon-o-key class="w-4 h-4" />
                        Akses Sistem
                    </a>
                    <a href="{{ route('users.edit', $user) }}"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white transition shadow-md"
                        style="background: linear-gradient(135deg, #6B56A5, #56438a) !important;">
                        <x-heroicon-o-pencil-square class="w-4 h-4" />
                        Edit
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6"
            style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">

            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-white text-2xl font-bold flex-shrink-0"
                    style="background: linear-gradient(135deg, #6B56A5, #56438a) !important;">
                    {{ $user->initials }}
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-xl font-bold" style="color: #1f2937 !important;">
                        {{ $user->name }}
                    </h2>
                    <p class="text-sm" style="color: #9ca3af !important;">{{ $user->email }}</p>

                    <div class="flex flex-wrap gap-2 justify-center md:justify-start mt-3">
                        <span
                            class="inline-block px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wide text-white"
                            style="background: {{ $user->user_type->badgeColor() }} !important;">
                            {{ $user->user_type->label() }}
                        </span>
                        @if ($user->is_active)
                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-bold uppercase"
                                style="background: rgba(0, 167, 156, 0.15) !important; color: #00A79C !important;">
                                Aktif
                            </span>
                        @else
                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-bold uppercase"
                                style="background: rgba(107, 114, 128, 0.15) !important; color: #6b7280 !important;">
                                Nonaktif
                            </span>
                        @endif
                        @if ($user->is_super_admin)
                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-bold uppercase"
                                style="background: rgba(86, 67, 138, 0.15) !important; color: #56438a !important;">
                                Super Admin
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mt-6 pt-6 border-t border-gray-100">
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
                            <div class="text-xs uppercase tracking-wide" style="color: #9ca3af !important;">
                                {{ $label }}
                            </div>
                            <div class="text-sm font-medium mt-0.5" style="color: #1f2937 !important;">
                                {{ $value }}
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        @if ($user->systems->isNotEmpty())
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
                style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold" style="color: #1f2937 !important;">Akses Sistem</h3>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-2">
                        @foreach ($user->systems as $s)
                            <div class="px-3 py-1.5 rounded-lg text-sm flex items-center gap-2"
                                style="background: rgba(107, 86, 165, 0.08) !important;">
                                <span class="font-medium" style="color: #6B56A5 !important;">{{ $s->name }}</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase"
                                    style="background: {{ $s->color }}20 !important; color: {{ $s->color }} !important;">
                                    {{ $s->pivot->role }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
