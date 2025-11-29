<x-app-layout>
    <div class="min-h-screen bg-[#0B1120] text-gray-300">
        
        <x-slot name="header">
        </x-slot>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                
                {{-- JUDUL HALAMAN --}}
                <div class="mb-8">
                    <h2 class="font-bold text-3xl text-white leading-tight">
                        {{ __('Edit Component') }}
                    </h2>
                    <p class="text-gray-400 text-sm mt-2">Inventory > Edit > {{ $product->name }}</p>
                </div>

                {{-- CARD UTAMA (GELAP) --}}
                <div class="bg-[#151B2D] shadow-2xl sm:rounded-2xl overflow-hidden border border-[#2D3748]">
                    
                    <div class="px-8 py-6 border-b border-[#2D3748] bg-[#151B2D] flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-black text-white">Component Specifications</h3>
                            <p class="text-sm text-gray-400 mt-1">Update technical details for SKU: <span class="text-blue-400 font-mono">{{ $product->sku }}</span></p>
                        </div>
                    </div>

                    <div class="p-8">
                        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                
                                {{-- KIRI --}}
                                <div class="space-y-6">
                                    <div class="border-b pb-2 border-[#2D3748] mb-4">
                                        <h4 class="text-sm font-bold text-blue-400 uppercase tracking-wider">Identity & Classification</h4>
                                    </div>
                                    
                                    {{-- SKU --}}
                                    <div>
                                        <x-input-label for="sku" :value="__('SKU')" class="font-bold !text-gray-300" />
                                        <input id="sku" class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#1A202C] text-gray-500 shadow-sm py-2.5 cursor-not-allowed" type="text" name="sku" value="{{ old('sku', $product->sku) }}" readonly />
                                        <p class="text-[10px] text-gray-500 mt-1 italic">Unique identifier cannot be changed.</p>
                                    </div>

                                    {{-- Nama --}}
                                    <div>
                                        <x-input-label for="name" :value="__('Component Name')" class="font-bold !text-gray-300" />
                                        <input id="name" class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5" type="text" name="name" value="{{ old('name', $product->name) }}" required />
                                        @error('name') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                    </div>

                                    {{-- Kategori --}}
                                    <div>
                                        <x-input-label for="category_id" :value="__('Category')" class="font-bold !text-gray-300" />
                                        <select id="category_id" name="category_id" class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }} class="bg-[#151B2D]">
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                    </div>

                                    {{-- Unit --}}
                                    <div>
                                        <x-input-label for="unit" :value="__('Unit Type')" class="font-bold !text-gray-300" />
                                        <input id="unit" class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5" type="text" name="unit" value="{{ old('unit', $product->unit) }}" required />
                                        @error('unit') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                {{-- KANAN --}}
                                <div class="space-y-6">
                                    <div class="border-b pb-2 border-[#2D3748] mb-4">
                                        <h4 class="text-sm font-bold text-blue-400 uppercase tracking-wider">Inventory & Pricing</h4>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        {{-- Harga Beli --}}
                                        <div>
                                            <x-input-label for="purchase_price" :value="__('Buy Price')" class="font-bold !text-gray-300" />
                                            <div class="relative mt-2">
                                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">Rp</span>
                                                <input id="purchase_price" class="pl-10 block w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5" type="number" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" required />
                                            </div>
                                            @error('purchase_price') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                        </div>

                                        {{-- Harga Jual --}}
                                        <div>
                                            <x-input-label for="sale_price" :value="__('Sell Price')" class="font-bold !text-gray-300" />
                                            <div class="relative mt-2">
                                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">Rp</span>
                                                <input id="sale_price" class="pl-10 block w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5" type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" required />
                                            </div>
                                            @error('sale_price') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                        </div>
                                    </div>

                                    {{-- Box Stok --}}
                                    <div class="p-5 bg-[#1A202C] rounded-xl border border-[#2D3748]">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <x-input-label for="stock_current" :value="__('Current Stock')" class="font-bold !text-gray-300" />
                                                <input id="stock_current" class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5" type="number" name="stock_current" value="{{ old('stock_current', $product->stock_current) }}" required />
                                            </div>
                                            <div>
                                                <x-input-label for="stock_minimum" :value="__('Min. Alert')" class="font-bold !text-gray-300" />
                                                <input id="stock_minimum" class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5" type="number" name="stock_minimum" value="{{ old('stock_minimum', $product->stock_minimum) }}" required />
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-3 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Adjust limits for automated alerts.
                                        </p>
                                    </div>

                                    {{-- Lokasi Rak --}}
                                    <div>
                                        <x-input-label for="storage_location" :value="__('Location')" class="font-bold !text-gray-300" />
                                        <input id="storage_location" class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5" type="text" name="storage_location" value="{{ old('storage_location', $product->storage_location) }}" />
                                        @error('storage_location') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- BAGIAN BAWAH: Detail & Gambar --}}
                            <div class="mt-8 space-y-6">
                                <div>
                                    <x-input-label for="description" :value="__('Technical Description')" class="font-bold !text-gray-300" />
                                    <textarea id="description" name="description" class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm" rows="4">{{ old('description', $product->description) }}</textarea>
                                    @error('description') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>

                                {{-- Image Upload Block --}}
                                <div>
                                    <x-input-label for="image_path" :value="__('Component Image')" class="font-bold !text-gray-300" />
                                    
                                    {{-- Preview Gambar Lama --}}
                                    @if($product->image_path)
                                        <div class="my-3 flex items-center p-3 bg-[#1A202C] rounded-lg border border-[#2D3748] w-fit">
                                            <img src="{{ Storage::url($product->image_path) }}" class="h-16 w-16 rounded-lg object-cover border border-[#4A5568]">
                                            <div class="ml-4">
                                                <p class="text-sm font-bold text-gray-300">Current Image</p>
                                                <p class="text-xs text-gray-500">Upload new to replace</p>
                                            </div>
                                        </div>

                                        {{-- ⚠️ OPSI HAPUS GAMBAR LAMA --}}
                                        <div class="mb-4">
                                            <label class="flex items-center space-x-2 text-gray-400 cursor-pointer">
                                                <input type="checkbox" name="delete_current_image" value="1" class="rounded border-[#4A5568] text-red-600 shadow-sm focus:ring-red-500 bg-[#0B1120]"/>
                                                <span class="text-sm font-bold hover:text-red-400 transition">Delete Current Image Permanently</span>
                                            </label>
                                        </div>
                                    @endif

                                    <input id="image_path" type="file" name="image_path" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition border border-[#4A5568] rounded-lg cursor-pointer bg-[#2D3748] focus:outline-none" />
                                    @error('image_path') <p class="text-red-400 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            {{-- TOMBOL FOOTER --}}
                            <div class="flex items-center justify-end gap-4 mt-10 pt-6 border-t border-[#2D3748]">
                                <a href="{{ route('products.index') }}" class="px-6 py-2.5 text-sm font-bold text-gray-300 bg-[#2D3748] border border-[#4A5568] rounded-lg hover:bg-[#374151] hover:text-white transition shadow-sm">Cancel</a>
                                <button type="submit" class="px-6 py-2.5 bg-amber-500 text-white font-bold text-sm rounded-lg shadow-lg shadow-amber-500/20 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-all transform hover:-translate-y-0.5">Update Changes</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>