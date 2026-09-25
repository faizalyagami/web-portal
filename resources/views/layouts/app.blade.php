<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal') - Portal Psikologi Unisba</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #6B56A5;
            --primary-dark: #56438a;
            --primary-light: #8b78c2;
            --secondary: #00A79C;
            --secondary-dark: #00847c;
            --accent: #F69320;
            --accent-dark: #d97a0a;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
            --text-light: #9ca3af;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #ffffff;
            color: var(--text-dark);
        }

        .primary-gradient {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        }

        .secondary-gradient {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--secondary-dark) 100%);
        }

        .accent-gradient {
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%);
        }

        .pattern-islamic {
            background-image:
                radial-gradient(circle at 1px 1px, rgba(107, 86, 165, 0.08) 1px, transparent 0);
            background-size: 32px 32px;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    @stack('styles')
</head>

<body class="min-h-screen flex flex-col">

    {{-- ============================================ --}}
    {{-- TOP NAVBAR --}}
    {{-- ============================================ --}}
    <nav class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                {{-- Left: Logo + Menu --}}
                <div class="flex items-center gap-6">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('brand-fakultas.jpg') }}" alt="Fakultas Psikologi Unisba"
                            class="h-10 md:h-11 w-auto object-contain group-hover:scale-105 transition-transform">
                    </a>

                    @auth
                        @if (auth()->user()->is_super_admin || auth()->user()->isAdmin())
                            <div class="hidden lg:flex items-center gap-1">
                                <a href="{{ route('dashboard') }}"
                                    class="px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('dashboard') ? 'bg-[#6B56A5]/10 text-[#6B56A5]' : 'text-gray-600 hover:bg-gray-100' }}">
                                    Dashboard
                                </a>
                                <a href="{{ route('users.index') }}"
                                    class="px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('users.*') ? 'bg-[#6B56A5]/10 text-[#6B56A5]' : 'text-gray-600 hover:bg-gray-100' }}">
                                    User
                                </a>
                                <a href="{{ route('systems.index') }}"
                                    class="px-3 py-2 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('systems.*') ? 'bg-[#6B56A5]/10 text-[#6B56A5]' : 'text-gray-600 hover:bg-gray-100' }}">
                                    Sistem
                                </a>
                            </div>
                        @endif
                    @endauth
                </div>

                {{-- Right: Profile --}}
                <div class="flex items-center gap-3">
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center gap-2 p-1 rounded-lg hover:bg-gray-100 transition">
                                <div
                                    class="w-9 h-9 rounded-full primary-gradient flex items-center justify-center text-white font-bold text-sm shadow">
                                    {{ auth()->user()->initials }}
                                </div>
                                <div class="hidden md:block text-left">
                                    <div class="text-sm font-semibold leading-tight" style="color: #1f2937;">
                                        {{ auth()->user()->name }}
                                    </div>
                                    <div class="text-xs" style="color: #9ca3af;">
                                        {{ auth()->user()->user_type->label() }}
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            {{-- Dropdown --}}
                            <div x-show="open" @click.away="open = false" x-transition x-cloak
                                class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden">

                                {{-- Header --}}
                                <div class="p-4 border-b border-gray-100">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div
                                            class="w-10 h-10 rounded-full primary-gradient flex items-center justify-center text-white font-bold text-sm">
                                            {{ auth()->user()->initials }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-semibold text-sm truncate" style="color: #1f2937;">
                                                {{ auth()->user()->name }}
                                            </div>
                                            <div class="text-xs truncate" style="color: #9ca3af;">
                                                {{ auth()->user()->email }}
                                            </div>
                                        </div>
                                    </div>

                                    <span
                                        class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide text-white"
                                        style="background: {{ auth()->user()->user_type->badgeColor() }}">
                                        {{ auth()->user()->user_type->label() }}
                                    </span>

                                    @if (auth()->user()->identifier)
                                        <div class="text-xs mt-2" style="color: #6b7280;">
                                            {{ auth()->user()->identifier_label }}:
                                            <span class="font-medium">{{ auth()->user()->identifier }}</span>
                                        </div>
                                    @endif

                                    @if (auth()->user()->jabatan)
                                        <div class="text-xs" style="color: #6b7280;">{{ auth()->user()->jabatan }}</div>
                                    @endif
                                </div>

                                {{-- Menu --}}
                                <div class="p-2">
                                    <a href="{{ route('profile.edit') }}"
                                        class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition">
                                        <x-heroicon-o-user-circle class="w-4 h-4" />
                                        Profil Saya
                                    </a>

                                    @if (auth()->user()->is_super_admin || auth()->user()->isAdmin())
                                        <a href="{{ route('users.index') }}"
                                            class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition">
                                            <x-heroicon-o-users class="w-4 h-4" />
                                            Manajemen User
                                        </a>
                                        <a href="{{ route('systems.index') }}"
                                            class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition">
                                            <x-heroicon-o-cog-6-tooth class="w-4 h-4" />
                                            Manajemen Sistem
                                        </a>
                                    @endif
                                </div>

                                {{-- Logout --}}
                                <div class="p-2 border-t border-gray-100">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition"
                                            style="color: #d97a0a;"
                                            onmouseover="this.style.background='rgba(246, 147, 32, 0.08)'"
                                            onmouseout="this.style.background='transparent'">
                                            <x-heroicon-o-arrow-right-on-rectangle class="w-4 h-4" />
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- ============================================ --}}
    {{-- MAIN CONTENT --}}
    {{-- ============================================ --}}
    <main class="pattern-islamic flex-1">
        @yield('content')
    </main>

    {{-- ============================================ --}}
    {{-- FOOTER --}}
    {{-- ============================================ --}}
    <footer class="border-t border-gray-100 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-sm" style="color: #9ca3af;">
                    © {{ date('Y') }}
                    <span class="font-semibold" style="color: #6B56A5;">Fakultas Psikologi Unisba</span>.
                    All rights reserved.
                </div>
                <div class="text-xs" style="color: #9ca3af;">
                    Dikembangkan oleh <span class="font-medium">Fakultas Psikologi Unisba</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
