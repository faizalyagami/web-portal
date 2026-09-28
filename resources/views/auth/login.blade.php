<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Portal Psikologi Unisba</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        html,
        body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow-x: hidden;
            color: var(--text-dark);
        }

        /* === BACKGROUND DECORATION === */
        .bg-shapes {
            position: fixed;
            inset: 0;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.3;
        }

        .shape-1 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--primary-light), transparent 70%);
            top: -150px;
            left: -150px;
            animation: float 20s ease-in-out infinite;
        }

        .shape-2 {
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, var(--secondary), transparent 70%);
            bottom: -120px;
            right: -120px;
            animation: float 25s ease-in-out infinite reverse;
        }

        .shape-3 {
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, var(--accent), transparent 70%);
            top: 40%;
            right: 20%;
            opacity: 0.12;
            animation: float 22s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(40px, -30px) scale(1.1);
            }
        }

        /* === PATTERN OVERLAY === */
        .bg-pattern {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            opacity: 0.5;
            background-image:
                radial-gradient(circle at 1px 1px, rgba(107, 86, 165, 0.1) 1px, transparent 0);
            background-size: 32px 32px;
        }

        /* === LOGIN CARD === */
        .login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            border-radius: 24px;
            padding: 40px 36px;
            box-shadow:
                0 30px 60px -12px rgba(107, 86, 165, 0.2),
                0 0 0 1px rgba(107, 86, 165, 0.06);
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* === LOGO === */
        .logo-box {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 24px rgba(107, 86, 165, 0.3);
            margin: 0 auto 20px;
            transition: transform 0.3s;
        }

        .logo-box:hover {
            transform: scale(1.05) rotate(-3deg);
        }

        /* === BADGE === */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 999px;
            background: rgba(0, 167, 156, 0.08);
            border: 1px solid rgba(0, 167, 156, 0.25);
            color: var(--secondary-dark);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--secondary);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(1.3);
            }
        }

        /* === INPUT === */
        .input-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .input-field {
            width: 100%;
            padding: 13px 16px 13px 44px;
            background: #f9fafb;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            color: var(--text-dark);
            font-size: 14px;
            font-family: inherit;
            transition: all 0.25s;
        }

        .input-field::placeholder {
            color: var(--text-light);
        }

        .input-field:focus {
            outline: none;
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(107, 86, 165, 0.12);
        }

        .input-field:hover:not(:focus) {
            border-color: rgba(107, 86, 165, 0.3);
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            pointer-events: none;
            display: flex;
            align-items: center;
        }

        /* === BUTTON PRIMARY === */
        .btn-primary {
            position: relative;
            width: 100%;
            padding: 14px 20px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #ffffff;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 0.3px;
            cursor: pointer;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 20px rgba(107, 86, 165, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: inherit;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent, rgba(255, 255, 255, 0.25), transparent);
            transform: translateX(-100%);
            transition: transform 0.7s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(107, 86, 165, 0.4);
        }

        .btn-primary:hover::before {
            transform: translateX(100%);
        }

        .btn-primary:active {
            transform: translateY(0) scale(0.98);
        }

        /* === FADE IN === */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
        }

        .d1 {
            animation-delay: 0.1s;
        }

        .d2 {
            animation-delay: 0.2s;
        }

        .d3 {
            animation-delay: 0.3s;
        }

        .d4 {
            animation-delay: 0.4s;
        }

        /* === DIVIDER === */
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(107, 86, 165, 0.2), transparent);
            margin: 24px 0;
        }

        /* === ACCENT STRIP === */
        .accent-strip {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            border-radius: 24px 24px 0 0;
            background: linear-gradient(90deg,
                    var(--primary) 0%,
                    var(--primary) 33%,
                    var(--secondary) 33%,
                    var(--secondary) 66%,
                    var(--accent) 66%,
                    var(--accent) 100%);
        }
    </style>
</head>

<body>

    <div class="bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    <div class="bg-pattern"></div>

    <div class="login-card">
        <div class="accent-strip"></div>

        {{-- Logo & Brand --}}
        <div class="text-center mb-7 fade-in">
            <img src="{{ asset('logo-fakultas.jpg') }}" alt="Fakultas Psikologi Unisba"
                class="h-16 md:h-20 w-auto object-contain mx-auto mb-2">

            <p class="text-xs font-semibold tracking-widest" style="color: #9ca3af;">
                PORTAL SISTEM INFORMASI FAKULTAS PSIKOLOGI UNISBA
            </p>
        </div>

        {{-- Welcome --}}
        <div class="text-center mb-6 fade-in d1">
            <div class="badge mb-4">
                <span class="badge-dot"></span>
                SISTEM INFORMASI FAPSI
            </div>
            <h2 class="text-lg font-bold mb-1" style="color: #1f2937;">
                Assalamu'alaikum
            </h2>
            <p class="text-xs" style="color: #9ca3af;">
                Silakan masuk untuk melanjutkan
            </p>
        </div>

        @if (session('status'))
            <div class="mb-4 p-3 rounded-lg text-xs fade-in"
                style="background: rgba(0, 167, 156, 0.08); border: 1px solid rgba(0, 167, 156, 0.25); color: #00847c;">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg text-xs flex items-start gap-2 fade-in"
                style="background: rgba(246, 147, 32, 0.08); border: 1px solid rgba(246, 147, 32, 0.3); color: #b8690a;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2" style="flex-shrink: 0; margin-top: 1px;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4 fade-in d2">
                <label for="login" class="input-label">Email / NPM / NIK</label>
                <div class="relative">
                    <div class="input-icon">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="text" id="login" name="login" value="{{ old('login') }}" required autofocus
                        autocomplete="username" placeholder="nama@unisba.ac.id atau 10012345" class="input-field">
                </div>
                @error('login')
                    <p class="text-xs mt-1.5" style="color: #d97a0a;">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 fade-in d3">
                <div class="flex justify-between items-center mb-2">
                    <label for="password" class="input-label" style="margin-bottom: 0;">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="font-semibold hover:underline transition"
                            style="color: #6B56A5; font-size: 11px;">
                            Lupa password?
                        </a>
                    @endif
                </div>
                <div class="relative" x-data="{ show: false }">
                    <div class="input-icon">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input :type="show ? 'text' : 'password'" id="password" name="password" required
                        autocomplete="current-password" placeholder="••••••••" class="input-field"
                        style="padding-right: 44px;">
                    <button type="button" @click="show = !show"
                        class="absolute top-1/2 -translate-y-1/2 p-1.5 rounded-lg transition hover:bg-gray-100"
                        style="right: 10px; color: #9ca3af; transform: translateY(-50%);">
                        <svg x-show="!show" width="18" height="18" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="show" width="18" height="18" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-xs mt-1.5" style="color: #d97a0a;">{{ $message }}</p>
                @enderror
            </div>

            <label class="flex items-center gap-2.5 cursor-pointer mb-5 fade-in d3" style="padding: 2px 0;">
                <input type="checkbox" name="remember"
                    style="width: 16px; height: 16px; border-radius: 4px; accent-color: #6B56A5; cursor: pointer;">
                <span class="text-xs font-medium" style="color: #6b7280;">
                    Ingat saya di perangkat ini
                </span>
            </label>

            <button type="submit" class="btn-primary fade-in d4">
                <span>Masuk ke Portal</span>
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </button>
        </form>

        <div class="divider"></div>

        <div class="text-center fade-in d4">
            <p class="text-xs" style="color: #9ca3af; line-height: 1.6;">
                Butuh bantuan?
                <a href="#" class="font-semibold hover:underline transition" style="color: #6B56A5;">
                    Hubungi Fakultas Psikologi Unisba
                </a>
            </p>
        </div>
    </div>

</body>

</html>
