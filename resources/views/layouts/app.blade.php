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
    
    <body class="font-sans antialiased bg-[#0B1120] text-gray-300" x-data="{ sidebarOpen: false }">
        
        <div class="min-h-screen flex flex-col">
            
            {{-- HEADER MOBILE --}}
            <header class="lg:hidden bg-[#151B2D] border-b border-[#2D3748] p-4 flex justify-between items-center fixed top-0 w-full z-50">
                <span class="text-xl font-black tracking-tight text-white">AERO<span class="text-blue-500">WMS</span></span>
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="sidebarOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </header>

            {{-- SIDEBAR --}}
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full lg:translate-x-0 bg-[#151B2D] border-r border-[#2D3748] pt-16 lg:pt-0">
                @include('layouts.navigation')
            </aside>

            {{-- OVERLAY MOBILE --}}
            <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 z-30 bg-black/50 lg:hidden"></div>

            {{-- KONTEN UTAMA (DENGAN FLEX UTK FOOTER) --}}
            <main class="flex-1 lg:ml-64 flex flex-col min-h-screen pt-20 lg:pt-0 transition-all duration-300">
                
                {{-- WRAPPER KONTEN (Supaya konten expand mengisi ruang kosong) --}}
                <div class="flex-1 px-4 sm:px-6 lg:px-8 py-8">
                    
                    {{-- GLOBAL ALERT SYSTEM --}}
                    <div class="max-w-7xl mx-auto mb-6">
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
                    
                </div>

                {{-- === FOOTER APLIKASI === --}}
                <footer class="border-t border-[#2D3748] bg-[#0B1120] py-6 mt-auto">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="text-xs text-gray-500 flex items-center">
                            <span class="w-2 h-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                            <span>System Operational</span>
                        </div>
                        
                        <div class="text-xs text-gray-600 text-center md:text-right font-mono">
                            &copy; {{ date('Y') }} Aerospace WMS. <br class="md:hidden"> All rights reserved.
                        </div>
                    </div>
                </footer>
                
            </main>
        </div>
    </body>
</html>