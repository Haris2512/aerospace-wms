<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Aerospace WMS</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800,900" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body, html {
                height: 100%;
                margin: 0;
                font-family: 'Instrument Sans', sans-serif;
            }
            
            .hero-section {
                background-image: url('{{ asset('images/galaxy.png') }}');
                height: 100vh;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                position: relative;
                display: flex;
                flex-direction: column; /* Kunci agar footer bisa di bawah */
            }

            .hero-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.6);
                background: radial-gradient(circle at center, rgba(11, 17, 32, 0.4) 0%, rgba(11, 17, 32, 0.9) 100%);
                z-index: 1;
            }

            .content-layer {
                position: relative;
                z-index: 10;
                width: 100%;
            }
        </style>
    </head>
    
    <body class="antialiased text-gray-100 overflow-hidden">
        
        <div class="hero-section">
            <div class="hero-overlay"></div>

            {{-- === HEADER (LOGO & MENU) === --}}
            <header class="content-layer w-full py-6 px-8">
                <div class="max-w-7xl mx-auto flex justify-between items-center">
                    
                    {{-- Logo (Kiri) --}}
                    <div class="flex items-center gap-3 group cursor-default">
                        <div class="p-2.5 bg-blue-600/20 border border-blue-500/30 rounded-xl shadow-[0_0_15px_rgba(37,99,235,0.3)] group-hover:shadow-[0_0_25px_rgba(37,99,235,0.5)] transition-all duration-300">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-2xl font-black tracking-tighter text-white leading-none">AERO<span class="text-blue-500">WMS</span></span>
                            <span class="text-[10px] uppercase tracking-[0.2em] text-blue-200/60 font-medium">System v1.0</span>
                        </div>
                    </div>

                    {{-- Menu (Kanan) --}}
                    @if (Route::has('login'))
                        <nav class="flex items-center gap-6">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-bold rounded-full transition backdrop-blur-md flex items-center gap-2 group">
                                    Dashboard
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-300 hover:text-white font-semibold text-sm transition-colors tracking-wide">
                                    LOG IN
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-bold text-sm rounded-full shadow-lg shadow-blue-600/20 transition-all transform hover:-translate-y-0.5 hover:shadow-blue-600/40 border border-blue-500">
                                        SUPPLIER REGISTER
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
            </header>

            {{-- === MAIN CONTENT (CENTER) === --}}
            <main class="content-layer flex-grow flex flex-col items-center justify-center text-center px-4 relative">
                
                {{-- Hiasan Latar Belakang Teks (Glow) --}}
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-500/10 rounded-full blur-[120px] pointer-events-none"></div>

                <div class="mb-8 animate-fade-in-up">
                    <span class="px-4 py-1.5 rounded-full bg-blue-950/50 border border-blue-500/30 text-blue-300 text-xs font-bold uppercase tracking-widest backdrop-blur-md shadow-[0_0_15px_rgba(37,99,235,0.15)]">
                        🚀 Advanced Inventory Control
                    </span>
                </div>

                <h1 class="text-6xl md:text-8xl font-black text-white tracking-tight leading-tight mb-6 drop-shadow-2xl max-w-5xl">
                    BEYOND THE <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-300 to-blue-400 bg-[length:200%_auto] animate-shine">STARS</span>
                </h1>

                <p class="text-lg md:text-xl text-blue-100/80 max-w-2xl mx-auto mb-12 leading-relaxed font-light">
                    Manage high-precision aerospace components with absolute reliability. 
                    Real-time tracking, secure approvals, and mission-critical logistics.
                </p>

                <div class="flex flex-col sm:flex-row gap-5">
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white font-bold text-lg rounded-2xl shadow-xl shadow-blue-600/30 transition-all transform hover:scale-105 hover:shadow-blue-600/50 border-t border-blue-400">
                        Start Mission Control
                    </a>
                    <a href="#features" class="px-8 py-4 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-bold text-lg rounded-2xl backdrop-blur-md transition-all hover:border-white/30">
                        System Documentation
                    </a>
                </div>

            </main>

            {{-- === FOOTER (BOTTOM FIXED) === --}}
            <footer class="content-layer w-full border-t border-white/5 bg-black/20 backdrop-blur-lg">
                <div class="max-w-7xl mx-auto px-8 py-6 flex flex-col md:flex-row justify-between items-center gap-4">
                    
                    {{-- Copyright (Kiri) --}}
                    <div class="text-gray-500 text-xs flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        <p>&copy; 2025 Aerospace WMS. Security Clearance Required.</p>
                    </div>
                    
                    {{-- Stats (Kanan) --}}
                    <div class="flex gap-8 md:gap-12">
                        <div class="text-center">
                            <span class="block text-lg font-bold text-white">99.9%</span>
                            <span class="text-[10px] uppercase tracking-widest text-blue-400/80 font-semibold">Uptime</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-lg font-bold text-white">Zero</span>
                            <span class="text-[10px] uppercase tracking-widest text-blue-400/80 font-semibold">Discrepancy</span>
                        </div>
                        <div class="text-center hidden sm:block">
                            <span class="block text-lg font-bold text-white">24/7</span>
                            <span class="text-[10px] uppercase tracking-widest text-blue-400/80 font-semibold">Monitoring</span>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
    </body>
</html>