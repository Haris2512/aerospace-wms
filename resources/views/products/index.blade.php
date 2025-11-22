<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            {{ __('Aerospace Components') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50"> {{-- Background halaman lebih soft --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Messages (Desain lebih rapi) --}}
            @if(session('success'))
                <div class="mb-6 flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-medium">Success!</span> {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="bg-white shadow-lg sm:rounded-xl border border-gray-200">
                <div class="p-6">
                    
                    {{-- HEADER TABEL & TOMBOL TAMBAH --}}
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Inventory List</h3>
                            <p class="text-sm text-gray-500">Manage your aerospace components stock.</p>
                        </div>
                        
                        {{-- INI TOMBOL TAMBAHNYA --}}
                        <a href="{{ route('products.create') }}" class="inline-flex items-center px-5 py-3 bg-indigo-600 border border-transparent rounded-lg font-bold text-base text-white hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-200 shadow-lg hover:shadow-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add New Component
                        </a>
                    </div>

                    {{-- TABEL DATA --}}
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Image</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">SKU & Name</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Category</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pricing</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Stock Status</th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($products as $product)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        {{-- 1. Gambar --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($product->image_path)
                                                <img src="{{ Storage::url($product->image_path) }}" class="h-12 w-12 rounded-lg object-cover border border-gray-200 shadow-sm">
                                            @else
                                                <div class="h-12 w-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>

                                        {{-- 2. SKU & Nama --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">{{ $product->sku }}</div>
                                            <div class="text-sm text-gray-600">{{ $product->name }}</div>
                                            <div class="text-xs text-gray-400 mt-1 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $product->storage_location ?? 'No Loc' }}
                                            </div>
                                        </td>

                                        {{-- 3. Kategori --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-700 border border-slate-200">
                                                {{ $product->category->name ?? 'Uncategorized' }}
                                            </span>
                                        </td>

                                        {{-- 4. Harga --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-xs text-gray-500">Buy: Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</div>
                                            <div class="text-sm font-semibold text-gray-800">Sell: Rp {{ number_format($product->sale_price, 0, ',', '.') }}</div>
                                        </td>

                                        {{-- 5. Status Stok --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $stock = $product->stock_current;
                                                $min = $product->stock_minimum;
                                                $isLow = $stock <= $min;
                                                $isEmpty = $stock == 0;
                                            @endphp
                                            
                                            <div class="flex items-center">
                                                <div class="text-sm font-bold {{ $isLow ? 'text-red-600' : 'text-emerald-600' }}">
                                                    {{ $stock }} {{ $product->unit }}
                                                </div>
                                                
                                                @if($isEmpty)
                                                    <span class="ml-2 px-2 py-0.5 text-xs rounded bg-red-100 text-red-800 border border-red-200">Empty</span>
                                                @elseif($isLow)
                                                    <span class="ml-2 px-2 py-0.5 text-xs rounded bg-amber-100 text-amber-800 border border-amber-200">Low</span>
                                                @else
                                                    <span class="ml-2 px-2 py-0.5 text-xs rounded bg-green-100 text-green-800 border border-green-200">OK</span>
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-400 mt-1">Min Alert: {{ $min }}</div>
                                        </td>

                                        {{-- 6. Aksi --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-3">
                                                <a href="{{ route('products.show', $product) }}" class="text-blue-500 hover:text-blue-700 transition duration-150" title="View Details">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>

                                                <a href="{{ route('products.edit', $product) }}" class="text-amber-500 hover:text-amber-700 transition duration-150" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                
                                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this component?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 transition duration-150" title="Delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-10 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                                <p class="text-gray-500 text-lg">No components found.</p>
                                                <p class="text-gray-400 text-sm">Get started by adding a new component to the inventory.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>