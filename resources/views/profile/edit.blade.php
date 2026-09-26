@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-6">
            <h1 class="text-2xl font-bold" style="color: #1f2937 !important;">Profil Saya</h1>
            <p class="text-sm mt-1" style="color: #9ca3af !important;">
                Kelola informasi akun dan keamanan Anda
            </p>
        </div>

        @if (session('status') === 'profile-updated')
            <div class="mb-4 p-4 rounded-xl text-sm"
                style="background: rgba(0, 167, 156, 0.08) !important; border: 1px solid rgba(0, 167, 156, 0.25); color: #00847c !important;">
                Profil berhasil diperbarui.
            </div>
        @elseif(session('status') === 'password-updated')
            <div class="mb-4 p-4 rounded-xl text-sm"
                style="background: rgba(0, 167, 156, 0.08) !important; border: 1px solid rgba(0, 167, 156, 0.25); color: #00847c !important;">
                Password berhasil diperbarui.
            </div>
        @elseif(session('status') === 'avatar-updated')
            <div class="mb-4 p-4 rounded-xl text-sm"
                style="background: rgba(0, 167, 156, 0.08) !important; border: 1px solid rgba(0, 167, 156, 0.25); color: #00847c !important;">
                Foto profil berhasil diperbarui.
            </div>
        @endif

        <div class="space-y-6">
            {{-- Card Identitas --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6"
                style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="relative">
                        <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-white text-2xl font-bold shadow-lg"
                            style="background: linear-gradient(135deg, #6B56A5, #56438a) !important;">
                            {{ auth()->user()->initials }}
                        </div>
                    </div>
                    <div class="text-center md:text-left flex-1">
                        <h2 class="text-xl font-bold" style="color: #1f2937 !important;">
                            {{ auth()->user()->name }}
                        </h2>
                        <p class="text-sm" style="color: #9ca3af !important;">{{ auth()->user()->email }}</p>
                        <div class="flex flex-wrap gap-2 justify-center md:justify-start mt-3">
                            <span
                                class="inline-block px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wide text-white"
                                style="background: {{ auth()->user()->user_type->badgeColor() }} !important;">
                                {{ auth()->user()->user_type->label() }}
                            </span>
                            @if (auth()->user()->identifier)
                                <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold"
                                    style="background: rgba(107, 86, 165, 0.1) !important; color: #6B56A5 !important;">
                                    {{ auth()->user()->identifier_label }}: {{ auth()->user()->identifier }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Update Informasi --}}
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
                style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold" style="color: #1f2937 !important;">Informasi Pribadi</h3>
                    <p class="text-sm mt-1" style="color: #9ca3af !important;">Perbarui informasi akun Anda</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
                style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold" style="color: #1f2937 !important;">Keamanan</h3>
                    <p class="text-sm mt-1" style="color: #9ca3af !important;">Ubah password akun Anda</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete --}}
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden"
                style="box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold" style="color: #dc2626 !important;">Zona Berbahaya</h3>
                    <p class="text-sm mt-1" style="color: #9ca3af !important;">Tindakan ini tidak dapat dibatalkan</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
