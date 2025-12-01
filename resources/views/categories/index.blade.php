<x-app-layout>
    {{-- Override background default --}}
    <div class="min-h-screen bg-[#0B1120] text-gray-300 font-sans">
        
        <x-slot name="header">
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                @if(session('error'))
                    <div class="mb-6 p-4 bg-[#7F1D1D] border border-[#B91C1C] text-red-100 rounded-lg flex items-center shadow-lg shadow-red-900/20">
                        <svg class="w-5 h-5 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-bold mr-1">Error!</span> {{ session('error') }}
                    </div>
                @endif

                {{-- CARD UTAMA --}}
                <div class="bg-[#151B2D] shadow-2xl sm:rounded-2xl overflow-hidden border border-[#2D3748]">
                    
                    {{-- HEADER --}}
                    <div class="p-6 border-b border-[#2D3748] flex flex-col md:flex-row justify-between items-center bg-[#151B2D] gap-4">
                        <div>
                            <h3 class="text-2xl font-black text-white tracking-tight">Categories</h3>
                            <p class="text-sm font-medium text-gray-400 mt-1">Organize your aerospace inventory.</p>
                        </div>
                        
                        <a href="{{ route('categories.create') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow-lg shadow-blue-600/20 border border-transparent transition-all transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Add Category
                        </a>
                    </div>

                    {{-- TABEL --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#2D3748]">
                            <thead class="bg-[#1A202C]">
                                <tr>
                                    {{-- SEMUA HEADER RATA TENGAH (text-center) --}}
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-[#2D3748]">#</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-[#2D3748]">Image</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-[#2D3748]">Name</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-[#2D3748]">Description</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-[#2D3748]">Products</th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[#151B2D] divide-y divide-[#2D3748]">
                                @forelse ($categories as $category)
                                    <tr class="hover:bg-[#1F2937] transition duration-150 group">
                                        
                                        {{-- NOMOR (Tengah) --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono text-center border-r border-[#2D3748]">
                                            {{ $loop->iteration }}
                                        </td>

                                        {{-- GAMBAR (Tengah) --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-[#2D3748]">
                                            <div class="flex justify-center">
                                                @if($category->image_path)
                                                    <img src="{{ Storage::url($category->image_path) }}" alt="{{ $category->name }}" class="h-10 w-10 rounded-lg object-cover border border-[#4A5568]">
                                                @else
                                                    <div class="h-10 w-10 rounded-lg bg-[#2D3748] flex items-center justify-center text-[10px] text-gray-500 border border-[#4A5568]">No Img</div>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- NAMA (Tengah) --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-[#2D3748]">
                                            <div class="text-sm font-bold text-white group-hover:text-blue-400 transition">{{ $category->name }}</div>
                                        </td>

                                        {{-- DESKRIPSI (Tengah) --}}
                                        <td class="px-6 py-4 text-sm text-gray-400 text-center border-r border-[#2D3748] max-w-xs truncate">
                                            {{ $category->description ?? '-' }}
                                        </td>

                                        {{-- JUMLAH PRODUK (Tengah) --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-[#2D3748]">
                                            <span class="px-2.5 py-1 inline-flex text-xs font-bold rounded-full bg-blue-900/30 text-blue-400 border border-blue-800">
                                                {{ $category->products_count }} Items
                                            </span>
                                        </td>

                                        {{-- AKSI (Tengah) --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="{{ route('categories.edit', $category) }}" class="p-2 bg-[#1A202C] border border-[#374151] rounded-lg text-gray-400 hover:text-amber-400 hover:border-amber-500/50 transition shadow-sm" title="Edit">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </a>
                                                
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
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
                                                <svg class="w-16 h-16 mb-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                                                <p class="text-lg font-medium text-gray-400">No categories found</p>
                                                <a href="{{ route('categories.create') }}" class="mt-4 text-blue-500 hover:text-blue-400 font-medium hover:underline">Create first category &rarr;</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Footer Pagination (Dark) --}}
                    <div class="px-6 py-4 bg-[#1A202C] border-t border-[#2D3748]">
                        {{ $categories->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>