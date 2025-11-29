<x-app-layout>
    {{-- Override background default layout --}}
    <div class="min-h-screen bg-[#0B1120] text-gray-300 font-sans">

        <x-slot name="header">
            {{-- Header slot dikosongkan atau disesuaikan jika perlu --}}
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Header & Tombol Kembali --}}
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="font-bold text-3xl text-white leading-tight">
                            {{ __('Component Details') }}
                        </h2>
                        <p class="text-gray-400 text-sm mt-2">Inventory > {{ $product->name }}</p>
                    </div>

                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-[#1F2937] border border-[#374151] rounded-lg font-semibold text-xs text-gray-300 uppercase tracking-widest hover:bg-[#374151] hover:text-white transition ease-in-out duration-150 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- KARTU UTAMA (Detail Produk - GELAP) --}}
                    <div
                        class="lg:col-span-2 bg-[#151B2D] shadow-2xl sm:rounded-2xl overflow-hidden border border-[#2D3748]">

                        <div class="p-8">
                            <div class="flex flex-col md:flex-row gap-8">

                                {{-- BAGIAN GAMBAR (Lightbox) --}}
                                <div class="flex-shrink-0" x-data="{ open: false }">
                                    @if($product->image_path)
                                        <div @click="open = true" class="relative group cursor-pointer">
                                            <img src="{{ Storage::url($product->image_path) }}"
                                                class="w-56 h-56 rounded-2xl object-cover border border-[#2D3748] shadow-lg transition transform group-hover:scale-105 group-hover:shadow-blue-500/20"
                                                alt="{{ $product->name }}">

                                            <div
                                                class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 rounded-2xl transition flex items-center justify-center">
                                                <span
                                                    class="bg-black/70 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-white opacity-0 group-hover:opacity-100 transition transform translate-y-2 group-hover:translate-y-0 border border-gray-600">
                                                    Zoom Image
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Modal Lightbox (Dark) --}}
                                        <div x-show="open" style="display: none;"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/95 p-4 backdrop-blur-sm"
                                            @keydown.escape.window="open = false">

                                            <button @click="open = false"
                                                class="absolute top-6 right-6 text-gray-400 hover:text-white transition">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                            <img src="{{ Storage::url($product->image_path) }}"
                                                class="max-w-full max-h-full rounded-lg shadow-2xl border border-gray-800"
                                                @click.outside="open = false">
                                        </div>
                                    @else
                                        <div
                                            class="w-56 h-56 rounded-2xl bg-[#0B1120] flex flex-col items-center justify-center text-gray-500 font-bold border-2 border-dashed border-[#2D3748]">
                                            <svg class="w-12 h-12 mb-2 text-gray-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            No Image
                                        </div>
                                    @endif
                                </div>

                                {{-- Info Detail --}}
                                <div class="flex-1 space-y-6">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-2xl font-black text-white">{{ $product->name }}</h3>
                                            <p class="text-sm font-mono text-blue-400 font-bold mt-1">
                                                {{ $product->sku }}</p>
                                        </div>
                                        <span
                                            class="px-3 py-1 rounded-full bg-[#1F2937] text-gray-300 text-xs font-bold border border-[#374151] shadow-sm">
                                            {{ $product->category->name ?? 'Uncategorized' }}
                                        </span>
                                    </div>

                                    {{-- Deskripsi --}}
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                            Technical Specs</h4>
                                        <div
                                            class="p-4 bg-[#0B1120] rounded-xl border border-[#2D3748] text-sm text-gray-400 leading-relaxed">
                                            {{ $product->description ?? 'No technical specifications provided.' }}
                                        </div>
                                    </div>

                                    {{-- Info Lokasi & Unit --}}
                                    <div class="grid grid-cols-2 gap-4">
                                        <div
                                            class="flex items-center gap-3 p-3 rounded-lg bg-[#1F2937] border border-[#374151]">
                                            <div class="p-2 bg-[#151B2D] rounded-md text-blue-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-[10px] text-gray-500 uppercase font-bold">Location</p>
                                                <p class="text-sm font-bold text-white">
                                                    {{ $product->storage_location ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div
                                            class="flex items-center gap-3 p-3 rounded-lg bg-[#1F2937] border border-[#374151]">
                                            <div class="p-2 bg-[#151B2D] rounded-md text-green-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-[10px] text-gray-500 uppercase font-bold">Unit Type</p>
                                                <p class="text-sm font-bold text-white">{{ $product->unit }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-8 border-[#2D3748]">

                            {{-- Statistik Harga --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div
                                    class="p-5 rounded-xl bg-[#1F2937] border border-[#374151] flex justify-between items-center group hover:border-blue-500/50 transition">
                                    <div>
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                                            Purchase Price</p>
                                        <p class="text-xl font-black text-white">Rp
                                            {{ number_format($product->purchase_price, 0, ',', '.') }}</p>
                                    </div>
                                    <div
                                        class="h-10 w-10 rounded-full bg-[#151B2D] border border-[#2D3748] flex items-center justify-center text-blue-400 group-hover:text-blue-300 group-hover:scale-110 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div
                                    class="p-5 rounded-xl bg-[#1F2937] border border-[#374151] flex justify-between items-center group hover:border-green-500/50 transition">
                                    <div>
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Selling
                                            Price</p>
                                        <p class="text-xl font-black text-white">Rp
                                            {{ number_format($product->sale_price, 0, ',', '.') }}</p>
                                    </div>
                                    <div
                                        class="h-10 w-10 rounded-full bg-[#151B2D] border border-[#2D3748] flex items-center justify-center text-green-400 group-hover:text-green-300 group-hover:scale-110 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KARTU KANAN (Status Stok & Aksi - GELAP) --}}
                    <div class="lg:col-span-1 space-y-6">

                        {{-- Kartu Stok --}}
                        <div class="bg-[#151B2D] shadow-xl sm:rounded-2xl overflow-hidden border border-[#2D3748] p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Current Inventory
                                </h4>
                                @if($product->stock_current <= $product->stock_minimum)
                                    <span class="flex h-3 w-3 relative">
                                        <span
                                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                    </span>
                                @else
                                    <span
                                        class="h-2.5 w-2.5 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.5)]"></span>
                                @endif
                            </div>

                            <div class="text-center py-4">
                                <span
                                    class="text-6xl font-black text-white tracking-tighter">{{ $product->stock_current }}</span>
                                <span class="text-gray-500 font-medium block mt-2 text-sm">{{ $product->unit }}
                                    available</span>
                            </div>

                            {{-- Progress Bar Gelap --}}
                            <div class="mt-6 space-y-2">
                                <div class="flex justify-between text-xs font-bold">
                                    <span
                                        class="{{ $product->stock_current <= $product->stock_minimum ? 'text-red-400' : 'text-gray-500' }}">
                                        Min Alert: {{ $product->stock_minimum }}
                                    </span>
                                    <span class="text-gray-500">Level</span>
                                </div>

                                @php
                                    $percentage = $product->stock_minimum > 0 ? ($product->stock_current / ($product->stock_minimum * 2)) * 100 : 100;
                                    $color = $product->stock_current <= $product->stock_minimum ? 'bg-red-500 shadow-[0_0_10px_rgba(239,68,68,0.5)]' : 'bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.5)]';
                                @endphp

                                <div class="w-full bg-[#0B1120] rounded-full h-2 border border-[#2D3748]">
                                    <div class="{{ $color }} h-2 rounded-full transition-all duration-500"
                                        style="width: {{ min($percentage, 100) }}%"></div>
                                </div>

                                @if($product->stock_current <= $product->stock_minimum)
                                    <div
                                        class="mt-4 flex items-start p-3 bg-red-900/20 rounded-lg border border-red-900/50">
                                        <svg class="w-5 h-5 text-red-400 mr-2 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                            </path>
                                        </svg>
                                        <div>
                                            <p class="text-xs font-bold text-red-400">Critical Low Stock!</p>
                                            <p class="text-[10px] text-red-300/70 mt-0.5">Immediate restock required to
                                                maintain operations.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Tombol Aksi Cepat --}}
                        <div class="bg-[#151B2D] shadow-xl sm:rounded-2xl overflow-hidden border border-[#2D3748] p-6">
                            <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Quick Actions</h4>
                            <div class="flex flex-col gap-3">
                                <a href="{{ route('products.edit', $product) }}"
                                    class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 text-white font-bold text-sm rounded-lg hover:bg-blue-700 transition shadow-lg shadow-blue-600/20 border border-transparent">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                    Edit Component
                                </a>

                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                    onsubmit="return confirm('Are you sure? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full flex items-center justify-center px-4 py-3 bg-[#0B1120] text-red-400 font-bold text-sm rounded-lg border border-red-900/30 hover:bg-red-900/20 hover:border-red-500/50 transition">
                                        Delete Component
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>