<x-app-layout>
    {{-- Override background default --}}
    <div class="min-h-screen bg-[#0B1120] text-gray-300 font-sans">
        
        <x-slot name="header">
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Alert Messages --}}
                @if(session('success'))
                    <div class="mb-6 p-4 bg-[#064E3B] border border-[#059669] text-green-100 rounded-lg flex items-center shadow-lg shadow-green-900/20">
                        <svg class="w-5 h-5 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="font-bold mr-1">Success!</span> {{ session('success') }}
                    </div>
                @endif

                {{-- CARD UTAMA --}}
                <div class="bg-[#151B2D] shadow-2xl sm:rounded-2xl overflow-hidden border border-[#2D3748]">
                    
                    {{-- HEADER --}}
                    <div class="p-6 border-b border-[#2D3748] flex flex-col md:flex-row justify-between items-center bg-[#151B2D] gap-4">
                        <div>
                            <h3 class="text-2xl font-black text-white tracking-tight">Component Inventory</h3>
                            <p class="text-sm font-medium text-gray-400 mt-1">Manage aerospace parts and stock levels.</p>
                        </div>
                        
                        <a href="{{ route('products.create') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow-lg shadow-blue-600/20 border border-transparent transition-all transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Add Component
                        </a>
                    </div>

                    {{-- TABEL --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#2D3748]">
                            <thead class="bg-[#1A202C]">
                                <tr>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-[#2D3748]">Image</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-[#2D3748]">SKU / Name</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-[#2D3748]">Category</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-[#2D3748]">Pricing</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-[#2D3748]">Stock Status</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[#151B2D] divide-y divide-[#2D3748]">
                                @forelse ($products as $product)
                                    <tr class="hover:bg-[#1F2937] transition duration-150 group">
                                        
                                        {{-- GAMBAR --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-[#2D3748]">
                                            <div class="flex justify-center">
                                                @if($product->image_path)
                                                    <img src="{{ Storage::url($product->image_path) }}" class="h-12 w-12 rounded-lg object-cover border border-[#4A5568]">
                                                @else
                                                    <div class="h-12 w-12 rounded-lg bg-[#2D3748] flex items-center justify-center text-[10px] text-gray-500 border border-[#4A5568]">No Img</div>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- SKU & NAMA --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-[#2D3748]">
                                            <div class="text-sm font-black text-white group-hover:text-blue-400 transition">{{ $product->sku }}</div>
                                            <div class="text-xs text-gray-400">{{ $product->name }}</div>
                                            <div class="text-[10px] text-gray-500 mt-1">Loc: {{ $product->storage_location ?? '-' }}</div>
                                        </td>

                                        {{-- KATEGORI --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-[#2D3748]">
                                            <span class="px-2.5 py-1 inline-flex text-xs font-bold rounded-full bg-[#1A202C] text-gray-300 border border-[#374151]">
                                                {{ $product->category->name ?? 'Uncategorized' }}
                                            </span>
                                        </td>

                                        {{-- PRICING --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-[#2D3748]">
                                            <div class="text-sm font-bold text-green-400">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</div>
                                            <div class="text-[10px] text-gray-500">Buy: {{ number_format($product->purchase_price, 0, ',', '.') }}</div>
                                        </td>

                                        {{-- STOCK STATUS (Logika Warna) --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-[#2D3748]">
                                            @php
                                                $stock = $product->stock_current;
                                                $min = $product->stock_minimum;
                                                $isLow = $stock <= $min;
                                            @endphp

                                            @if($stock == 0)
                                                <span class="px-2.5 py-1 inline-flex text-xs font-bold rounded-full bg-red-900/30 text-red-400 border border-red-800">OUT OF STOCK</span>
                                            @elseif($isLow)
                                                <span class="px-2.5 py-1 inline-flex text-xs font-bold rounded-full bg-yellow-900/30 text-yellow-400 border border-yellow-800 animate-pulse">LOW: {{ $stock }}</span>
                                            @else
                                                <span class="px-2.5 py-1 inline-flex text-xs font-bold rounded-full bg-green-900/30 text-green-400 border border-green-800">SAFE: {{ $stock }}</span>
                                            @endif
                                            <div class="text-[10px] text-gray-500 mt-1">Min: {{ $min }} {{ $product->unit }}</div>
                                        </td>

                                        {{-- AKSI --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center space-x-2">
                                                {{-- Detail --}}
                                                <a href="{{ route('products.show', $product) }}" class="p-2 bg-[#1A202C] border border-[#374151] rounded-lg text-gray-400 hover:text-blue-400 hover:border-blue-500/50 transition shadow-sm" title="View">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </a>

                                                {{-- Edit --}}
                                                <a href="{{ route('products.edit', $product) }}" class="p-2 bg-[#1A202C] border border-[#374151] rounded-lg text-gray-400 hover:text-amber-400 hover:border-amber-500/50 transition shadow-sm" title="Edit">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </a>
                                                
                                                {{-- Hapus --}}
                                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 bg-[#1A202C] border border-[#374151] rounded-lg text-gray-400 hover:text-red-400 hover:border-red-500/50 transition shadow-sm" title="Delete">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-500">
                                                <svg class="w-16 h-16 mb-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                                <p class="text-lg font-medium text-gray-400">No components found</p>
                                                <a href="{{ route('products.create') }}" class="mt-4 text-blue-500 hover:text-blue-400 font-medium hover:underline">Create first component &rarr;</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Footer Pagination (Dark) --}}
                    <div class="px-6 py-4 bg-[#1A202C] border-t border-[#2D3748]">
                        {{ $products->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>