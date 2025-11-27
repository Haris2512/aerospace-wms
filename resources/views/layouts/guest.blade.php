<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Aerospace WMS') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-100 antialiased">
    {{-- Background Gelap --}}
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#0B1120]">

        {{-- Logo / Judul di Atas --}}
        <div class="mb-6 text-center">
            <a href="/" class="flex flex-col items-center gap-2">
                <div class="p-3 bg-blue-600/20 rounded-xl border border-blue-500/30">
                    <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </div>
                <span class="text-2xl font-black tracking-tight text-white">AEROSPACE <span
                        class="text-blue-500">WMS</span></span>
            </a>
        </div>

        {{-- Kartu Login (Gelap) --}}
        <div class="w-full sm:max-w-md mt-2 px-8 py-8 bg-[#151B2D] shadow-2xl border border-[#2D3748] sm:rounded-2xl">
            {{ $slot }}
        </div>

        <div class="mt-8 text-center text-xs text-gray-600">
            &copy; {{ date('Y') }} Aerospace Warehouse System. Restricted Access.
        </div>
    </div>
</body>

</html>