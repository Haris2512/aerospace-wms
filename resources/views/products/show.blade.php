@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Component') }}: {{ $product->name }}
        </h2>
        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition ease-in-out duration-150">
            &larr; Back to List
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- BAGIAN KIRI: Detail Lengkap Produk (Lebar 2/3) --}}
        <div class="md:col-span-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Product Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        {{-- Gambar --}}
                        <div class="md:col-span-2 flex justify-center mb-4">
                            @if($product->image_path)
                                <img src="{{ Storage::url($product->image_path) }}" class="max-h-64 rounded-lg shadow-md object-cover">
                            @else
                                <div class="h-48 w-full bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                    No Image Available
                                </div>
                            @endif
                        </div>

                        {{-- Info Dasar --}}
                        <div>
                            <p class="text-sm text-gray-500">SKU</p>
                            <p class="font-semibold">{{ $product->sku }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Category</p>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Purchase Price</p>
                            <p class="font-medium">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Selling Price</p>
                            <p class="font-medium text-green-600">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Weight</p>
                            <p class="font-medium">{{ $product->detail->weight ?? '-' }} kg</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Size</p>
                            <p class="font-medium">{{ $product->detail->size ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500">Description</p>
                            <p class="mt-1 text-gray-700 bg-gray-50 p-3 rounded">{{ $product->detail->description ?? 'No description provided.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN KANAN: Info Stok per Gudang (Lebar 1/3) --}}
        <div class="md:col-span-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Stock Availability</h3>
                    
                    <div class="mb-6 text-center p-4 bg-blue-50 rounded-lg border border-blue-100">
                        <p class="text-sm text-blue-600 uppercase font-bold tracking-wider">Total Stock</p>
                        <p class="text-3xl font-extrabold text-blue-800">{{ $product->stock_current }}</p>
                        <p class="text-xs text-blue-500">{{ $product->unit }}</p>
                    </div>

                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">By Warehouse</h4>
                    
                    <ul class="divide-y divide-gray-100">
                        {{-- Loop data gudang dari relasi Many-to-Many --}}
                        @forelse($product->warehouses as $warehouse)
                            <li class="py-3 flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $warehouse->name }}</p>
                                    <p class="text-xs text-gray-500 truncate w-32">{{ $warehouse->location }}</p>
                                </div>
                                
                                {{-- Ambil 'quantity' dari TABEL PIVOT --}}
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $warehouse->pivot->quantity }} {{ $product->unit }}
                                </span>
                            </li>
                        @empty
                            <li class="py-4 text-center text-gray-500 text-sm italic">
                                No stock in any warehouse.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection