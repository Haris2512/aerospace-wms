<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Aerospace WMS</title>

        <!-- Fonts & Styles (Pastikan Vite berjalan untuk Tailwind) -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    {{-- Background ini akan menggunakan gambar yang kamu buat --}}
    <body class="font-sans antialiased">
        <style>
            .galaxy-background {
                /* Gunakan gambar yang kamu buat tadi */
                background-image: url('{{ asset('images/galaxy.png') }}');;
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                position: relative;
                overflow: hidden;
            }
            .overlay {
                /* Lapisan gelap untuk membuat teks lebih kontras */
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.6); 
                backdrop-filter: blur(2px);
                z-index: 1;
            }
        </style>

        <div class="galaxy-background">
            <div class="overlay"></div>

            <header class="w-full absolute top-0 z-20 p-6">
                @if (Route::has('login'))
                    <nav class="flex items-center justify-end gap-4 max-w-7xl mx-auto">
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="inline-block px-5 py-2 border border-white/30 text-white font-medium rounded-lg text-sm transition-all hover:bg-white/10"
                            >
                                Dashboard Portal
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="inline-block px-5 py-2 border border-transparent text-white font-medium rounded-lg text-sm transition-all hover:text-blue-400"
                            >
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="inline-block px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-all shadow-lg"
                                >
                                    Register Supplier
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <main class="relative z-20 text-center max-w-4xl mx-auto p-8">
                <h1 class="text-7xl md:text-8xl font-extrabold text-white tracking-tight leading-none drop-shadow-lg">
                    AERO<span class="text-blue-400">SPACE</span>
                </h1>
                <h2 class="text-xl md:text-3xl text-gray-300 font-light mt-4 mb-10 tracking-widest uppercase">
                    Mission Control WMS
                </h2>
                
                <p class="text-lg text-white/90 max-w-2xl mx-auto mb-10 leading-relaxed">
                    Manage critical aerospace components with flight-grade precision. This platform provides real-time inventory tracking and multi-stage approval for secure operations.
                </p>

                <div class="flex justify-center space-x-6">
                    <a href="{{ route('login') }}" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-2xl shadow-blue-500/50 transition-all transform hover:scale-105">
                        Start Your Mission
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-3 bg-transparent border-2 border-white/50 text-white font-bold rounded-lg transition-all hover:bg-white/10">
                        View Demo
                    </a>
                </div>
            </main>
        </div>
    </body>
</html>