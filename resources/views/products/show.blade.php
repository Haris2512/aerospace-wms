<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            {{ __('Component Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Tombol Kembali --}}
            <a href="{{ route('products.index') }}"
                class="inline-flex items-center mb-6 text-sm font-medium text-gray-500 hover:text-gray-700 transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Inventory
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KARTU UTAMA (Detail Produk) --}}
                <div class="lg:col-span-2 bg-white shadow-xl sm:rounded-2xl overflow-hidden border border-gray-100">
                    <div class="p-8">
                        <div class="flex flex-col md:flex-row gap-8">

                            {{-- Gambar Produk --}}
                            <div class="flex-shrink-0">
                                @if($product->image_path)
                                    <img src="{{ Storage::url($product->image_path) }}"
                                        class="w-48 h-48 rounded-xl object-cover border border-gray-200 shadow-sm">
                                @else
                                    <div
                                        class="w-48 h-48 rounded-xl bg-gray-100 flex items-center justify-center text-gray-400 font-bold border border-gray-200">
                                        No Image
                                    </div>
                                @endif
                            </div>

                            {{-- Info Teks --}}
                            <div class="flex-1 space-y-4">
                                <div>
                                    <h3 class="text-2xl font-black text-gray-900">{{ $product->name }}</h3>
                                    <p class="text-sm font-mono text-indigo-600 font-bold mt-1">{{ $product->sku }}</p>
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    <span
                                        class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold border border-slate-200">
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    </span>
                                    <span
                                        class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-bold border border-gray-200">
                                        Loc: {{ $product->storage_location ?? 'Unknown' }}
                                    </span>
                                </div>

                                <div
                                    class="p-4 bg-gray-50 rounded-xl border border-gray-100 text-sm text-gray-600 leading-relaxed">
                                    <span class="font-bold block text-gray-800 mb-1">Description:</span>
                                    {{ $product->description ?? 'No description provided for this component.' }}
                                </div>
                            </div>
                        </div>

                        <hr class="my-8 border-gray-100">

                        {{-- Statistik Harga --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 rounded-xl bg-blue-50 border border-blue-100">
                                <p class="text-xs font-bold text-blue-600 uppercase tracking-wider">Purchase Price</p>
                                <p class="text-lg font-black text-gray-900">Rp
                                    {{ number_format($product->purchase_price, 0, ',', '.') }}</p>
                            </div>
                            <div class="p-4 rounded-xl bg-green-50 border border-green-100">
                                <p class="text-xs font-bold text-green-600 uppercase tracking-wider">Selling Price</p>
                                <p class="text-lg font-black text-gray-900">Rp
                                    {{ number_format($product->sale_price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KARTU KANAN (Status Stok) --}}
                <div class="lg:col-span-1 space-y-6">

                    {{-- Kartu Stok --}}
                    <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden border border-gray-100 p-6">
                        <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Stock Status</h4>

                        <div class="text-center py-4">
                            <span class="text-5xl font-black text-gray-900">{{ $product->stock_current }}</span>
                            <span class="text-gray-500 font-medium block mt-1">{{ $product->unit }} available</span>
                        </div>

                        {{-- Progress Bar untuk Stok Minimum --}}
                        <div class="mt-4">
                            <div class="flex justify-between text-xs font-bold mb-1">
                                <span
                                    class="{{ $product->stock_current <= $product->stock_minimum ? 'text-red-600' : 'text-gray-500' }}">
                                    Minimum: {{ $product->stock_minimum }}
                                </span>
                                <span class="text-gray-400">Status</span>
                            </div>

                            @php
                                $percentage = $product->stock_minimum > 0 ? ($product->stock_current / ($product->stock_minimum * 2)) * 100 : 100;
                                $color = $product->stock_current <= $product->stock_minimum ? 'bg-red-500' : 'bg-green-500';
                            @endphp

                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="{{ $color }} h-2.5 rounded-full transition-all duration-500"
                                    style="width: {{ min($percentage, 100) }}%"></div>
                            </div>

                            @if($product->stock_current <= $product->stock_minimum)
                                <div
                                    class="mt-3 flex items-center justify-center text-red-600 bg-red-50 p-2 rounded-lg border border-red-100">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    <span class="text-xs font-bold">Low Stock Warning!</span>
                                </div>
                            @else
                                <div
                                    class="mt-3 flex items-center justify-center text-green-700 bg-green-50 p-2 rounded-lg border border-green-100">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-xs font-bold">Stock Level Healthy</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Tombol Aksi Cepat --}}
                    <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden border border-gray-100 p-6">
                        <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Quick Actions</h4>
                        <div class="flex flex-col gap-3">
                            <a href="{{ route('products.edit', $product) }}"
                                class="w-full text-center px-4 py-2 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition shadow-sm">
                                Edit Component
                            </a>
                            {{-- (Nanti kita bisa tambah tombol 'Create Transaction' di sini) --}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>