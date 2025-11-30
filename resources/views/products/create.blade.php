<x-app-layout>
    {{-- Override background default layout --}}
    <div class="min-h-screen bg-[#0B1120] text-gray-300 font-sans">

        <x-slot name="header">
            {{-- Header slot dikosongkan --}}
        </x-slot>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

                {{-- === 1. AREA PESAN ERROR (PERBAIKAN UTAMA) === --}}
                {{-- Menampilkan Error Validasi (Wajib Isi, Format Salah, dll) --}}
                @if ($errors->any())
                    <div
                        class="mb-6 p-4 bg-red-900/30 border border-red-500/50 text-red-200 rounded-lg shadow-lg animate-pulse">
                        <div class="flex items-center mb-2">
                            <svg class="w-6 h-6 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            <strong class="font-bold text-lg">Submission Failed!</strong>
                        </div>
                        <ul class="list-disc list-inside text-sm space-y-1 ml-2 text-red-300">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Menampilkan Error Sistem (Database/Server Error) --}}
                @if(session('error'))
                    <div
                        class="mb-6 p-4 bg-[#7F1D1D] border border-[#B91C1C] text-red-100 rounded-lg flex items-center shadow-lg">
                        <svg class="w-5 h-5 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-bold mr-1">System Error:</span> {{ session('error') }}
                    </div>
                @endif
                {{-- === END AREA PESAN ERROR === --}}


                {{-- JUDUL HALAMAN DI ATAS CARD --}}
                <div class="mb-8">
                    <h2 class="font-bold text-3xl text-white leading-tight">
                        {{ __('Add New Component') }}
                    </h2>
                    <p class="text-gray-400 text-sm mt-2">Aerospace Inventory > Create</p>
                </div>

                {{-- CARD UTAMA (GELAP) --}}
                <div class="bg-[#151B2D] shadow-2xl sm:rounded-2xl overflow-hidden border border-[#2D3748]">

                    {{-- HEADER FORM DALAM CARD --}}
                    <div class="px-8 py-6 border-b border-[#2D3748] bg-[#151B2D]">
                        <h3 class="text-xl font-black text-white">Component Specifications</h3>
                        <p class="text-sm text-gray-400 mt-1">Fill in the technical details below.</p>
                    </div>

                    <div class="p-8">
                        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                                {{-- === KOLOM KIRI: IDENTITAS BARANG === --}}
                                <div class="space-y-6">
                                    <div class="border-b pb-2 border-[#2D3748] mb-4">
                                        <h4 class="text-sm font-bold text-blue-400 uppercase tracking-wider">Identity &
                                            Classification</h4>
                                    </div>

                                    {{-- SKU --}}
                                    <div>
                                        <x-input-label for="sku" :value="__('SKU (Code)')"
                                            class="font-bold !text-gray-300" />
                                        <input id="sku"
                                            class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                                            type="text" name="sku" value="{{ old('sku') }}" required
                                            placeholder="e.g. AV-2025-001" />
                                        {{-- Pesan error spesifik per field tetap ada --}}
                                        @error('sku') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}
                                        </p> @enderror
                                    </div>

                                    {{-- Nama Produk --}}
                                    <div>
                                        <x-input-label for="name" :value="__('Component Name')"
                                            class="font-bold !text-gray-300" />
                                        <input id="name"
                                            class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                                            type="text" name="name" value="{{ old('name') }}" required
                                            placeholder="e.g. Hydraulic Pump Titanium" />
                                        @error('name') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}
                                        </p> @enderror
                                    </div>

                                    {{-- Kategori --}}
                                    <div>
                                        <x-input-label for="category_id" :value="__('Category')"
                                            class="font-bold !text-gray-300" />
                                        <select id="category_id" name="category_id"
                                            class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5">
                                            <option value="" class="text-gray-500">-- Select Category --</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }} class="bg-[#151B2D]">
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id') <p class="text-red-400 text-xs mt-1 font-medium">
                                        {{ $message }}</p> @enderror
                                    </div>

                                    {{-- Unit --}}
                                    <div>
                                        <x-input-label for="unit" :value="__('Unit Type')"
                                            class="font-bold !text-gray-300" />
                                        <input id="unit"
                                            class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                                            type="text" name="unit" value="{{ old('unit') }}" required
                                            placeholder="e.g. Unit, Set, Assembly" />
                                        @error('unit') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}
                                        </p> @enderror
                                    </div>
                                </div>

                                {{-- === KOLOM KANAN: MANAJEMEN STOK & HARGA === --}}
                                <div class="space-y-6">
                                    <div class="border-b pb-2 border-[#2D3748] mb-4">
                                        <h4 class="text-sm font-bold text-blue-400 uppercase tracking-wider">Inventory &
                                            Pricing Logic</h4>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        {{-- Harga Beli --}}
                                        <div>
                                            <x-input-label for="purchase_price" :value="__('Buy Price')"
                                                class="font-bold !text-gray-300" />
                                            <div class="relative mt-2">
                                                <span
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">Rp</span>
                                                <input id="purchase_price"
                                                    class="pl-10 block w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                                                    type="number" name="purchase_price"
                                                    value="{{ old('purchase_price') }}" required placeholder="0" />
                                            </div>
                                            @error('purchase_price') <p class="text-red-400 text-xs mt-1 font-medium">
                                            {{ $message }}</p> @enderror
                                        </div>

                                        {{-- Harga Jual --}}
                                        <div>
                                            <x-input-label for="sale_price" :value="__('Sell Price')"
                                                class="font-bold !text-gray-300" />
                                            <div class="relative mt-2">
                                                <span
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">Rp</span>
                                                <input id="sale_price"
                                                    class="pl-10 block w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                                                    type="number" name="sale_price" value="{{ old('sale_price') }}"
                                                    required placeholder="0" />
                                            </div>
                                            @error('sale_price') <p class="text-red-400 text-xs mt-1 font-medium">
                                            {{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    {{-- Box Stok (Gelap) --}}
                                    <div class="p-5 bg-[#1A202C] rounded-xl border border-[#2D3748]">
                                        <div class="grid grid-cols-2 gap-4">
                                            {{-- Stok Awal --}}
                                            <div>
                                                <x-input-label for="stock_current" :value="__('Initial Stock')"
                                                    class="font-bold !text-gray-300" />
                                                <input id="stock_current"
                                                    class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                                                    type="number" name="stock_current"
                                                    value="{{ old('stock_current', 0) }}" required min="0" />
                                            </div>

                                            {{-- Stok Minimum --}}
                                            <div>
                                                <x-input-label for="stock_minimum" :value="__('Min. Alert Limit')"
                                                    class="font-bold !text-gray-300" />
                                                <input id="stock_minimum"
                                                    class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                                                    type="number" name="stock_minimum"
                                                    value="{{ old('stock_minimum', 5) }}" required min="0" />
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-3 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            Adjust limits for automated alerts.
                                        </p>
                                    </div>

                                    {{-- Lokasi Rak --}}
                                    <div>
                                        <x-input-label for="storage_location" :value="__('Shelf Location')"
                                            class="font-bold !text-gray-300" />
                                        <input id="storage_location"
                                            class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                                            type="text" name="storage_location" value="{{ old('storage_location') }}"
                                            placeholder="e.g. Hangar A, Rack C-12" />
                                    </div>
                                </div>
                            </div>

                            {{-- BAGIAN BAWAH: Detail & Gambar --}}
                            <div class="mt-8 space-y-6">
                                <div>
                                    <x-input-label for="description" :value="__('Technical Description')"
                                        class="font-bold !text-gray-300" />
                                    <textarea id="description" name="description"
                                        class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 shadow-sm"
                                        rows="4"
                                        placeholder="Enter detailed technical specifications, material composition, or compatibility notes...">{{ old('description') }}</textarea>
                                </div>

                                <div>
                                    <x-input-label for="image_path" :value="__('Component Image')"
                                        class="font-bold !text-gray-300" />
                                    <div class="mt-2 flex items-center">
                                        <input id="image_path" type="file" name="image_path"
                                            class="block w-full text-sm text-gray-400
                                            file:mr-4 file:py-2.5 file:px-4
                                            file:rounded-lg file:border-0
                                            file:text-sm file:font-bold
                                            file:bg-blue-600 file:text-white
                                            hover:file:bg-blue-700 transition
                                            border border-[#4A5568] rounded-lg cursor-pointer bg-[#2D3748] focus:outline-none" />
                                    </div>
                                    @error('image_path') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}
                                    </p> @enderror
                                    <p class="text-xs text-gray-500 mt-2">Required: JPG, PNG (Max 2MB). Must upload a
                                        clear photo.</p>
                                </div>
                            </div>

                            {{-- TOMBOL FOOTER (GELAP) --}}
                            <div class="flex items-center justify-end gap-4 mt-10 pt-6 border-t border-[#2D3748]">
                                <a href="{{ route('products.index') }}"
                                    class="px-6 py-2.5 text-sm font-bold text-gray-300 bg-[#2D3748] border border-[#4A5568] rounded-lg hover:bg-[#374151] hover:text-white transition shadow-sm">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="px-6 py-2.5 bg-blue-600 text-white font-bold text-sm rounded-lg shadow-lg shadow-blue-500/20 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-[#151B2D] transition-all transform hover:-translate-y-0.5">
                                    Save Component
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>