<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            {{ __('Aerospace Components Inventory') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100"> 
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="mb-6 p-4 text-sm font-bold text-green-900 bg-green-100 border border-green-400 rounded-lg">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 text-sm font-bold text-red-900 bg-red-100 border border-red-400 rounded-lg">
                    ❌ {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-md sm:rounded-xl border border-gray-300">
                <div class="p-6">
                    
                    {{-- HEADER & BUTTON --}}
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 border-b pb-4 border-gray-200">
                        <div>
                            <h3 class="text-xl font-extrabold text-gray-900">Stock List</h3>
                            <p class="text-sm font-medium text-gray-600">Manage warehouse inventory items.</p>
                        </div>
                        
                        <a href="{{ route('products.create') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-700 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-800 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                            + Add Component
                        </a>
                    </div>

                    {{-- TABEL DATA --}}
                    <div class="overflow-x-auto rounded-lg border border-gray-300">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-extrabold text-gray-800 uppercase tracking-wider border-r border-gray-200">Image</th>
                                    <th class="px-6 py-3 text-left text-xs font-extrabold text-gray-800 uppercase tracking-wider border-r border-gray-200">SKU / Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-extrabold text-gray-800 uppercase tracking-wider border-r border-gray-200">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-extrabold text-gray-800 uppercase tracking-wider border-r border-gray-200">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-extrabold text-gray-800 uppercase tracking-wider border-r border-gray-200">Stock</th>
                                    <th class="px-6 py-3 text-right text-xs font-extrabold text-gray-800 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($products as $product)
                                    <tr class="hover:bg-blue-50 transition duration-150">
                                        {{-- Gambar --}}
                                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-100">
                                            @if($product->image_path)
                                                <img src="{{ Storage::url($product->image_path) }}" class="h-16 w-16 rounded-md object-cover border border-gray-400 shadow-sm">
                                            @else
                                                <div class="h-16 w-16 rounded-md bg-gray-200 flex items-center justify-center text-gray-500 text-xs font-bold border border-gray-300">No Pic</div>
                                            @endif
                                        </td>

                                        {{-- SKU & Nama --}}
                                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-100">
                                            <div class="text-base font-black text-gray-900">{{ $product->sku }}</div>
                                            <div class="text-sm font-semibold text-gray-700">{{ $product->name }}</div>
                                            <div class="text-xs font-medium text-gray-500 mt-1 bg-gray-100 px-2 py-0.5 rounded inline-block border border-gray-300">
                                                📍 {{ $product->storage_location ?? 'No Loc' }}
                                            </div>
                                        </td>

                                        {{-- Kategori --}}
                                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-100">
                                            @if($product->category)
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                                    {{ $product->category->name }}
                                                </span>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-gray-200 text-gray-600 border border-gray-300">
                                                    Uncategorized
                                                </span>
                                                <div class="text-[10px] text-red-600 mt-1 font-bold">*Please Edit to add Category</div>
                                            @endif
                                        </td>

                                        {{-- Harga --}}
                                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-100">
                                            <div class="text-xs font-bold text-gray-500">Buy: <span class="text-gray-800">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</span></div>
                                            <div class="text-sm font-bold text-green-700">Sell: Rp {{ number_format($product->sale_price, 0, ',', '.') }}</div>
                                        </td>

                                        {{-- Status Stok --}}
                                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-100">
                                            @php
                                                $stock = $product->stock_current;
                                                $min = $product->stock_minimum;
                                                $isLow = $stock <= $min;
                                                $isEmpty = $stock == 0;
                                            @endphp
                                            
                                            <div class="flex flex-col">
                                                <span class="text-lg font-black {{ $isEmpty ? 'text-red-600' : 'text-gray-900' }}">
                                                    {{ $stock }} <span class="text-xs font-normal text-gray-600">{{ $product->unit }}</span>
                                                </span>
                                                
                                                @if($isEmpty)
                                                    <span class="mt-1 px-2 py-1 text-xs font-bold text-center text-white bg-red-600 rounded shadow-sm">EMPTY</span>
                                                @elseif($isLow)
                                                    <span class="mt-1 px-2 py-1 text-xs font-bold text-center text-amber-900 bg-amber-200 rounded shadow-sm border border-amber-300">LOW (Min: {{ $min }})</span>
                                                @else
                                                    <span class="mt-1 px-2 py-1 text-xs font-bold text-center text-green-800 bg-green-200 rounded shadow-sm border border-green-300">SAFE</span>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex flex-col space-y-2">
                                                <a href="{{ route('products.show', $product) }}" class="inline-flex justify-center px-3 py-1 bg-cyan-600 text-white text-xs font-bold rounded hover:bg-cyan-700 transition shadow">
                                                    View
                                                </a>
                                                <a href="{{ route('products.edit', $product) }}" class="inline-flex justify-center px-3 py-1 bg-amber-500 text-white text-xs font-bold rounded hover:bg-amber-600 transition shadow">
                                                    Edit
                                                </a>
                                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this item?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-full inline-flex justify-center px-3 py-1 bg-red-600 text-white text-xs font-bold rounded hover:bg-red-700 transition shadow">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center">
                                            <p class="text-gray-500 font-bold text-lg">No components found.</p>
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