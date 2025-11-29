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
            /* Styling khusus untuk Background Galaksi */
            body, html {
                height: 100%;
                margin: 0;
                font-family: 'Instrument Sans', sans-serif;
            }
            
            .hero-section {
                /* Ganti dengan path gambar yang benar */
                background-image: url('{{ asset('images/galaxy.png') }}');
                
                /* Agar gambar full screen dan responsive */
                height: 100vh;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                position: relative;
            }

            /* Lapisan Gelap di atas gambar agar teks terbaca */
            .hero-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.65); /* Tingkat kegelapan 65% */
                background: linear-gradient(to bottom, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.8) 100%);
            }

            .hero-content {
                position: relative;
                z-index: 10; /* Di atas overlay */
            }
        </style>
    </head>
    
    <body class="antialiased text-gray-100">
        
        <div class="hero-section flex flex-col justify-between">
            <div class="hero-overlay"></div>

            {{-- HEADER: LOGO & LOGIN --}}
            <header class="hero-content w-full p-6 flex justify-between items-center max-w-7xl mx-auto">
                
                {{-- Logo Kiri --}}
                <div class="flex items-center gap-2">
                    <div class="p-2 bg-blue-600 rounded-lg shadow-lg shadow-blue-500/50">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </div>
                    <span class="text-xl font-black tracking-tighter text-white">AERO<span class="text-blue-500">WMS</span></span>
                </div>

                {{-- Menu Kanan --}}
                @if (Route::has('login'))
                    <nav class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold rounded-full transition backdrop-blur-sm">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-300 hover:text-white font-medium transition">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full shadow-lg shadow-blue-600/30 transition transform hover:-translate-y-0.5">
                                    Supplier Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            {{-- MAIN CONTENT: HERO TEXT --}}
            <main class="hero-content flex-grow flex flex-col items-center justify-center text-center px-4">
                
                <div class="mb-6">
                    <span class="px-4 py-1.5 rounded-full bg-blue-900/50 border border-blue-500/50 text-blue-300 text-xs font-bold uppercase tracking-widest backdrop-blur-md shadow-lg">
                        Advanced Inventory System
                    </span>
                </div>

                <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white tracking-tight leading-tight mb-6 drop-shadow-2xl">
                    BEYOND THE <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400">STARS</span>
                </h1>

                <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto mb-10 leading-relaxed font-light">
                    Manage high-precision aerospace components with absolute reliability. 
                    Real-time tracking, secure approvals, and mission-critical logistics.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white font-bold text-lg rounded-xl shadow-2xl shadow-blue-600/40 transition transform hover:scale-105">
                        Start Mission Control
                    </a>
                    
                    <a href="#features" class="px-8 py-4 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-bold text-lg rounded-xl backdrop-blur-md transition">
                        Explore Features
                    </a>
                </div>

            </main>

            {{-- FOOTER: STATS --}}
            <footer class="hero-content pb-8 pt-4 border-t border-white/10 w-full bg-black/20 backdrop-blur-sm">
                <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4 text-gray-400 text-sm">
                    <p>&copy; 2025 Aerospace WMS. Security Clearance Required.</p>
                    
                    <div class="flex gap-8">
                        <div class="text-center">
                            <span class="block text-xl font-bold text-white">99.9%</span>
                            <span class="text-xs uppercase tracking-wider">Uptime</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-xl font-bold text-white">Zero</span>
                            <span class="text-xs uppercase tracking-wider">Discrepancy</span>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
    </body>
</html>