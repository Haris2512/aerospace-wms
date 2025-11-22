<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            {{ __('Add Component') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden border border-gray-100">
                
                {{-- HEADER FORM --}}
                <div class="px-8 py-6 border-b border-gray-100 bg-white">
                    <h3 class="text-xl font-black text-gray-900">New Component Entry</h3>
                    <p class="text-sm text-gray-500">Enter the details of the new aerospace part.</p>
                </div>

                <div class="p-8">
                    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            {{-- === KOLOM KIRI: IDENTITAS BARANG === --}}
                            <div class="space-y-6">
                                <div class="border-b pb-2 border-gray-100 mb-4">
                                    <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider">Identity</h4>
                                </div>
                                
                                {{-- SKU --}}
                                <div>
                                    <x-input-label for="sku" :value="__('SKU (Code)')" class="font-bold text-gray-700" />
                                    <input id="sku" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" type="text" name="sku" value="{{ old('sku') }}" required placeholder="e.g. AV-2025-001" />
                                    @error('sku') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>

                                {{-- Nama Produk --}}
                                <div>
                                    <x-input-label for="name" :value="__('Component Name')" class="font-bold text-gray-700" />
                                    <input id="name" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Hydraulic Pump" />
                                    @error('name') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>

                                {{-- Kategori --}}
                                <div>
                                    <x-input-label for="category_id" :value="__('Category')" class="font-bold text-gray-700" />
                                    <select id="category_id" name="category_id" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5 bg-white">
                                        <option value="">-- Select Category --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>

                                {{-- Unit --}}
                                <div>
                                    <x-input-label for="unit" :value="__('Unit Type')" class="font-bold text-gray-700" />
                                    <input id="unit" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" type="text" name="unit" value="{{ old('unit') }}" required placeholder="e.g. pcs, set, kg" />
                                    @error('unit') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            {{-- === KOLOM KANAN: MANAJEMEN STOK & HARGA === --}}
                            <div class="space-y-6">
                                <div class="border-b pb-2 border-gray-100 mb-4">
                                    <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider">Inventory & Pricing</h4>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    {{-- Harga Beli --}}
                                    <div>
                                        <x-input-label for="purchase_price" :value="__('Buy Price')" class="font-bold text-gray-700" />
                                        <div class="relative mt-1">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</span>
                                            <input id="purchase_price" class="pl-10 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" type="number" name="purchase_price" value="{{ old('purchase_price') }}" required />
                                        </div>
                                        @error('purchase_price') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                    </div>

                                    {{-- Harga Jual --}}
                                    <div>
                                        <x-input-label for="sale_price" :value="__('Sell Price')" class="font-bold text-gray-700" />
                                        <div class="relative mt-1">
                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">Rp</span>
                                            <input id="sale_price" class="pl-10 block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" type="number" name="sale_price" value="{{ old('sale_price') }}" required />
                                        </div>
                                        @error('sale_price') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                                    <div class="grid grid-cols-2 gap-4">
                                        {{-- Stok Awal --}}
                                        <div>
                                            <x-input-label for="stock_current" :value="__('Initial Stock')" class="font-bold text-gray-700" />
                                            <input id="stock_current" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5 bg-white" type="number" name="stock_current" value="{{ old('stock_current', 0) }}" required min="0" />
                                        </div>

                                        {{-- Stok Minimum --}}
                                        <div>
                                            <x-input-label for="stock_minimum" :value="__('Min. Alert Limit')" class="font-bold text-gray-700" />
                                            <input id="stock_minimum" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5 bg-white" type="number" name="stock_minimum" value="{{ old('stock_minimum', 5) }}" required min="0" />
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">*System will alert when stock hits minimum.</p>
                                </div>

                                {{-- Lokasi Rak --}}
                                <div>
                                    <x-input-label for="storage_location" :value="__('Shelf Location')" class="font-bold text-gray-700" />
                                    <input id="storage_location" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" type="text" name="storage_location" value="{{ old('storage_location') }}" placeholder="e.g. Rack C-12" />
                                </div>
                            </div>
                        </div>

                        {{-- BAGIAN BAWAH: Detail & Gambar --}}
                        <div class="mt-8 space-y-6">
                            <div>
                                <x-input-label for="description" :value="__('Description')" class="font-bold text-gray-700" />
                                <textarea id="description" name="description" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" rows="3" placeholder="Technical specifications...">{{ old('description') }}</textarea>
                            </div>

                            <div>
                                <x-input-label for="image_path" :value="__('Upload Image')" class="font-bold text-gray-700" />
                                <div class="mt-1 flex items-center">
                                    <input id="image_path" type="file" name="image_path" class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2.5 file:px-4
                                        file:rounded-lg file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-indigo-50 file:text-indigo-700
                                        hover:file:bg-indigo-100 transition
                                        border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />
                                </div>
                            </div>
                        </div>

                        {{-- TOMBOL --}}
                        <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-100">
                            <a href="{{ route('products.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-bold text-sm rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all transform hover:-translate-y-0.5">
                                Save Component
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>