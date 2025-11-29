<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Aerospace WMS</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    {{-- APLIKASI DARK MODE DITERAPKAN DI BODY --}}
    <body class="font-sans antialiased bg-[#0B1120] text-gray-300">
        
        <div class="min-h-screen">
            
            {{-- 1. SIDEBAR VERTICAL (FIXED DI KIRI) --}}
            @include('layouts.navigation')

            {{-- 2. PAGE HEADING (HEADER DI ATAS KONTEN) --}}
            @if (isset($header))
                <header class="bg-[#151B2D] shadow border-b border-[#2D3748] fixed top-0 left-64 right-0 z-10">
                    <div class="max-w-full mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            {{-- 3. PAGE CONTENT (BERGESER KE KANAN 64px) --}}
            <main class="lg:ml-64 pt-16"> 
                {{ $slot }}
            </main>
        </div>
    </body>
</html>