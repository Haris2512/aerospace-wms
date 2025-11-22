<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Component') }}: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Form Edit --}}
                    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- WAJIB ADA UNTUK EDIT --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            {{-- KOLOM KIRI --}}
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                                
                                {{-- SKU (Read Only jika tidak ingin diubah sembarangan, atau boleh diubah) --}}
                                <div class="mb-4">
                                    <x-input-label for="sku" :value="__('SKU')" />
                                    <x-text-input id="sku" class="block mt-1 w-full bg-gray-100" type="text" name="sku" :value="old('sku', $product->sku)" required />
                                    <x-input-error :messages="$errors->get('sku')" class="mt-2" />
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="name" :value="__('Component Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" required />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="category_id" :value="__('Category')" />
                                    <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="">-- Select Category --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="unit" :value="__('Unit')" />
                                    <x-text-input id="unit" class="block mt-1 w-full" type="text" name="unit" :value="old('unit', $product->unit)" required />
                                    <x-input-error :messages="$errors->get('unit')" class="mt-2" />
                                </div>
                            </div>

                            {{-- KOLOM KANAN --}}
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Stock & Pricing</h3>

                                <div class="mb-4">
                                    <x-input-label for="purchase_price" :value="__('Purchase Price (Rp)')" />
                                    <x-text-input id="purchase_price" class="block mt-1 w-full" type="number" name="purchase_price" :value="old('purchase_price', $product->purchase_price)" required step="0.01" />
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="sale_price" :value="__('Selling Price (Rp)')" />
                                    <x-text-input id="sale_price" class="block mt-1 w-full" type="number" name="sale_price" :value="old('sale_price', $product->sale_price)" required step="0.01" />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="mb-4">
                                        <x-input-label for="stock_current" :value="__('Current Stock')" />
                                        <x-text-input id="stock_current" class="block mt-1 w-full" type="number" name="stock_current" :value="old('stock_current', $product->stock_current)" required />
                                    </div>

                                    <div class="mb-4">
                                        <x-input-label for="stock_minimum" :value="__('Min. Stock Alert')" />
                                        <x-text-input id="stock_minimum" class="block mt-1 w-full" type="number" name="stock_minimum" :value="old('stock_minimum', $product->stock_minimum)" required />
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <x-input-label for="storage_location" :value="__('Storage Location')" />
                                    <x-text-input id="storage_location" class="block mt-1 w-full" type="text" name="storage_location" :value="old('storage_location', $product->storage_location)" />
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="3">{{ old('description', $product->description) }}</textarea>
                        </div>

                        {{-- Gambar Saat Ini --}}
                        @if($product->image_path)
                            <div class="mb-2">
                                <p class="text-sm text-gray-600 mb-1">Current Image:</p>
                                <img src="{{ Storage::url($product->image_path) }}" class="h-20 w-20 rounded object-cover border">
                            </div>
                        @endif

                        <div class="mb-4">
                            <x-input-label for="image_path" :value="__('Change Image (Optional)')" />
                            <input id="image_path" type="file" name="image_path" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            <x-input-error :messages="$errors->get('image_path')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-6">
                            <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900 text-sm font-medium underline">Cancel</a>
                            <x-primary-button>{{ __('Update Component') }}</x-primary-button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>