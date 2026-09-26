<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Portal Unisba') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen" style="background: #ffffff;">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4"
        style="background-image: radial-gradient(circle at 1px 1px, rgba(107, 86, 165, 0.06) 1px, transparent 0); background-size: 32px 32px;">

        <div class="mb-6">
            <a href="/">
                <img src="{{ asset('brand-fakultas.jpg') }}" alt="Fakultas Psikologi Unisba"
                    class="h-16 w-auto object-contain">
            </a>
        </div>

        <div class="w-full sm:max-w-md px-6 py-6 bg-white rounded-2xl overflow-hidden"
            style="box-shadow: 0 20px 40px -12px rgba(107, 86, 165, 0.15), 0 0 0 1px rgba(107, 86, 165, 0.08);">
            {{ $slot }}
        </div>

        <p class="mt-6 text-xs" style="color: #9ca3af;">
            © {{ date('Y') }} Fakultas Psikologi Unisba
        </p>
    </div>
</body>

</html>
