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
    
    {{-- 1. INISIALISASI STATE SIDEBAR (x-data) --}}
    <body class="font-sans antialiased bg-[#0B1120] text-gray-300" x-data="{ sidebarOpen: false }">
        
        <div class="min-h-screen flex flex-col">
            
            {{-- 2. HEADER MOBILE (Hanya di HP) --}}
            <header class="lg:hidden bg-[#151B2D] border-b border-[#2D3748] p-4 flex justify-between items-center fixed top-0 w-full z-50">
                <span class="text-xl font-black tracking-tight text-white">AERO<span class="text-blue-500">WMS</span></span>
                
                {{-- TOMBOL BURGER (Bisa diklik sekarang!) --}}
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {{-- Ikon berubah jadi X saat menu terbuka --}}
                        <path x-show="!sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="sidebarOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </header>

            {{-- 3. SIDEBAR (Menu Kiri) --}}
            {{-- Di Laptop (lg:block): Selalu muncul (static) --}}
            {{-- Di HP (:class): Muncul/Hilang berdasarkan sidebarOpen --}}
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full lg:translate-x-0 bg-[#151B2D] border-r border-[#2D3748] pt-16 lg:pt-0">
                @include('layouts.navigation')
            </aside>

            {{-- 4. OVERLAY GELAP (Hanya di HP saat menu terbuka) --}}
            <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 z-30 bg-black/50 lg:hidden"></div>

            {{-- 5. KONTEN UTAMA --}}
            <main class="flex-1 lg:ml-64 pt-20 lg:pt-6 px-4 sm:px-6 lg:px-8 transition-all duration-300">
                
                {{-- Global Alert System --}}
                <div class="max-w-7xl mx-auto mt-2 mb-6">
                    @if(session('success'))
                        <div class="mb-4 p-3 md:p-4 bg-[#064E3B] border border-[#059669] text-green-100 rounded-lg flex items-center shadow-lg animate-fade-in-down">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 md:mr-3 flex-shrink-0 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <div>
                                <span class="font-bold text-sm md:text-base">Success!</span> 
                                <span class="text-xs md:text-sm">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-3 md:p-4 bg-[#7F1D1D] border border-[#B91C1C] text-red-100 rounded-lg flex items-center shadow-lg animate-pulse">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 md:mr-3 flex-shrink-0 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <span class="font-bold block text-sm md:text-base">System Error</span>
                                <span class="text-xs md:text-sm">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 p-3 md:p-4 bg-red-900/30 border border-red-500/50 text-red-200 rounded-lg shadow-lg">
                            <div class="flex items-center mb-2">
                                <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <strong class="font-bold text-sm md:text-base">Input Error</strong>
                            </div>
                            <ul class="list-disc list-inside text-xs md:text-sm space-y-1 ml-1 md:ml-2 text-red-300">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                {{ $slot }}
                
            </main>
        </div>
    </body>
</html>