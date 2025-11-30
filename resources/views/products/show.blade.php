<x-app-layout>
    <div class="min-h-screen bg-[#0B1120] text-gray-300 font-sans">

        <x-slot name="header">
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Header & Tombol Kembali --}}
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="font-bold text-3xl text-white leading-tight">
                            {{ __('Component Details') }}
                        </h2>
                        <p class="text-gray-400 text-sm mt-2">Inventory > {{ $product->name }}</p>
                    </div>

                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-[#1F2937] border border-[#374151] rounded-lg font-semibold text-xs text-gray-300 uppercase tracking-widest hover:bg-[#374151] hover:text-white transition ease-in-out duration-150 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- KOLOM KIRI: INFO UTAMA & HISTORY --}}
                    <div class="lg:col-span-2 space-y-8">

                        {{-- KARTU UTAMA (Detail Produk) --}}
                        <div class="bg-[#151B2D] shadow-2xl sm:rounded-2xl overflow-hidden border border-[#2D3748]">
                            <div class="p-8">
                                <div class="flex flex-col md:flex-row gap-8">

                                    {{-- BAGIAN GAMBAR (Lightbox & Perbaikan Tampilan) --}}
                                    <div class="flex-shrink-0 w-full md:w-1/3" x-data="{ open: false }">
                                        @if($product->image_path)
                                            <div @click="open = true"
                                                class="relative group cursor-pointer aspect-square w-full bg-[#0B1120] rounded-2xl overflow-hidden border border-[#2D3748] flex items-center justify-center">

                                                {{-- Gambar Utama (Fit Contain agar tidak terpotong) --}}
                                                <img src="{{ Storage::url($product->image_path) }}"
                                                    class="max-w-full max-h-full object-contain p-2 transition transform group-hover:scale-105 duration-300"
                                                    alt="{{ $product->name }}">

                                                {{-- Overlay Zoom --}}
                                                <div
                                                    class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center backdrop-blur-sm">
                                                    <span
                                                        class="bg-white/10 px-4 py-2 rounded-full text-sm font-bold text-white border border-white/20 flex items-center gap-2">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7">
                                                            </path>
                                                        </svg>
                                                        Zoom View
                                                    </span>
                                                </div>
                                            </div>

                                            {{-- Modal Lightbox (Full Screen) --}}
                                            <div x-show="open" style="display: none;"
                                                x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-in duration-200"
                                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/95 p-4 backdrop-blur-md"
                                                @keydown.escape.window="open = false">

                                                <button @click="open = false"
                                                    class="absolute top-6 right-6 text-white/50 hover:text-white transition p-2 bg-white/10 rounded-full">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>

                                                <img src="{{ Storage::url($product->image_path) }}"
                                                    class="max-w-full max-h-screen rounded shadow-2xl"
                                                    @click.outside="open = false">
                                            </div>
                                        @else
                                            <div
                                                class="aspect-square w-full rounded-2xl bg-[#0B1120] flex flex-col items-center justify-center text-gray-500 font-bold border-2 border-dashed border-[#2D3748]">
                                                <svg class="w-16 h-16 mb-4 text-gray-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                No Image Uploaded
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Info Detail (Kanan Gambar) --}}
                                    <div class="flex-1 space-y-6">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="text-2xl font-black text-white">{{ $product->name }}</h3>
                                                <p class="text-sm font-mono text-blue-400 font-bold mt-1 tracking-wide">
                                                    {{ $product->sku }}</p>
                                            </div>
                                            <span
                                                class="px-3 py-1 rounded-full bg-[#1F2937] text-gray-300 text-xs font-bold border border-[#374151] shadow-sm">
                                                {{ $product->category->name ?? 'Uncategorized' }}
                                            </span>
                                        </div>

                                        <div>
                                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                                Technical Specs</h4>
                                            <div
                                                class="p-4 bg-[#0B1120] rounded-xl border border-[#2D3748] text-sm text-gray-400 leading-relaxed">
                                                {{ $product->description ?? 'No technical specifications provided.' }}
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div
                                                class="flex items-center gap-3 p-3 rounded-lg bg-[#1F2937] border border-[#374151]">
                                                <div class="p-2 bg-[#151B2D] rounded-md text-blue-400">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-[10px] text-gray-500 uppercase font-bold">Location
                                                    </p>
                                                    <p class="text-sm font-bold text-white">
                                                        {{ $product->storage_location ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                            <div
                                                class="flex items-center gap-3 p-3 rounded-lg bg-[#1F2937] border border-[#374151]">
                                                <div class="p-2 bg-[#151B2D] rounded-md text-green-400">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-[10px] text-gray-500 uppercase font-bold">Unit Type
                                                    </p>
                                                    <p class="text-sm font-bold text-white">{{ $product->unit }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-8 border-[#2D3748]">

                                {{-- Statistik Harga --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div
                                        class="p-5 rounded-xl bg-[#1F2937] border border-[#374151] flex justify-between items-center group hover:border-blue-500/50 transition">
                                        <div>
                                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                                                Purchase Price</p>
                                            <p class="text-xl font-black text-white">Rp
                                                {{ number_format($product->purchase_price, 0, ',', '.') }}</p>
                                        </div>
                                        <div
                                            class="h-10 w-10 rounded-full bg-[#151B2D] border border-[#2D3748] flex items-center justify-center text-blue-400 group-hover:text-blue-300 group-hover:scale-110 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div
                                        class="p-5 rounded-xl bg-[#1F2937] border border-[#374151] flex justify-between items-center group hover:border-green-500/50 transition">
                                        <div>
                                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                                                Selling Price</p>
                                            <p class="text-xl font-black text-white">Rp
                                                {{ number_format($product->sale_price, 0, ',', '.') }}</p>
                                        </div>
                                        <div
                                            class="h-10 w-10 rounded-full bg-[#151B2D] border border-[#2D3748] flex items-center justify-center text-green-400 group-hover:text-green-300 group-hover:scale-110 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- TABEL RIWAYAT TRANSAKSI (Last 5) --}}
                        <div class="bg-[#151B2D] shadow-2xl sm:rounded-2xl overflow-hidden border border-[#2D3748]">
                            <div
                                class="px-6 py-4 border-b border-[#2D3748] bg-[#1A202C] flex justify-between items-center">
                                <h3 class="font-bold text-white">Transaction History (Last 5)</h3>
                                <a href="{{ route('transactions.index') }}"
                                    class="text-xs text-blue-400 hover:underline">View All</a>
                            </div>
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-gray-400 uppercase bg-[#0B1120]">
                                    <tr>
                                        <th class="px-6 py-3 text-center">Date</th>
                                        <th class="px-6 py-3 text-center">Type</th>
                                        <th class="px-6 py-3 text-center">Qty</th>
                                        <th class="px-6 py-3 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#2D3748]">
                                    @forelse($product->transactions as $trx)
                                        <tr class="hover:bg-[#1F2937] transition">
                                            <td class="px-6 py-3 text-center text-gray-300">
                                                {{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }}</td>
                                            <td class="px-6 py-3 text-center">
                                                @if($trx->type == 'incoming')
                                                    <span class="text-blue-400 font-bold text-xs">INCOMING</span>
                                                @else
                                                    <span class="text-orange-400 font-bold text-xs">OUTGOING</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-3 text-center font-mono text-white">
                                                {{ $trx->pivot->quantity }}</td>
                                            <td class="px-6 py-3 text-center">
                                                <span
                                                    class="px-2 py-0.5 rounded text-[10px] font-bold {{ $trx->status == 'approved' ? 'bg-green-900/30 text-green-400' : 'bg-yellow-900/30 text-yellow-400' }}">
                                                    {{ strtoupper($trx->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No transactions
                                                found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>

                    {{-- KOLOM KANAN: QR CODE, STOK, AKSI --}}
                    <div class="lg:col-span-1 space-y-6">

                        {{-- 1. KARTU QR CODE (DIGITAL ASSET TAG) --}}
                        <div
                            class="bg-[#151B2D] shadow-xl sm:rounded-2xl overflow-hidden border border-[#2D3748] p-6 text-center relative group">
                            <div
                                class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500">
                            </div>

                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Digital Asset Tag
                            </h4>

                            <div class="flex justify-center mb-4 p-4 bg-white rounded-xl w-fit mx-auto">
                                {{-- Generate QR Code --}}
                                {!! QrCode::size(120)->backgroundColor(255, 255, 255)->color(0, 0, 0)->generate($product->sku) !!}
                            </div>

                            <p class="text-lg font-black text-white tracking-widest font-mono">{{ $product->sku }}</p>
                            <p class="text-[10px] text-gray-500 mt-1 mb-4">Scan to track component history</p>

                            {{-- TOMBOL PRINT BARU --}}
                            <div class="flex justify-center">
                                <a href="{{ route('products.print-qr', $product) }}" target="_blank"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-[#1F2937] hover:bg-[#374151] text-gray-300 text-xs font-bold rounded-lg border border-[#4A5568] transition shadow-sm z-10 relative group-hover:border-blue-500/50 group-hover:text-white">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                        </path>
                                    </svg>
                                    Print Label
                                </a>
                            </div>

                            <div
                                class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-0 group-hover:opacity-20 transition duration-1000 group-hover:duration-200">
                            </div>
                        </div>

                        {{-- 2. KARTU STOK --}}
                        <div class="bg-[#151B2D] shadow-xl sm:rounded-2xl overflow-hidden border border-[#2D3748] p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Current Inventory
                                </h4>
                                @if($product->stock_current <= $product->stock_minimum)
                                    <span class="flex h-3 w-3 relative">
                                        <span
                                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                    </span>
                                @else
                                    <span
                                        class="h-2.5 w-2.5 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.5)]"></span>
                                @endif
                            </div>

                            <div class="text-center py-4">
                                <span
                                    class="text-6xl font-black text-white tracking-tighter">{{ $product->stock_current }}</span>
                                <span class="text-gray-500 font-medium block mt-2 text-sm">{{ $product->unit }}
                                    available</span>
                            </div>

                            {{-- Progress Bar --}}
                            <div class="mt-6 space-y-2">
                                <div class="flex justify-between text-xs font-bold">
                                    <span
                                        class="{{ $product->stock_current <= $product->stock_minimum ? 'text-red-400' : 'text-gray-500' }}">
                                        Min Alert: {{ $product->stock_minimum }}
                                    </span>
                                    <span class="text-gray-400">Level</span>
                                </div>

                                @php
                                    $percentage = $product->stock_minimum > 0 ? ($product->stock_current / ($product->stock_minimum * 2)) * 100 : 100;
                                    $color = $product->stock_current <= $product->stock_minimum ? 'bg-red-500 shadow-[0_0_10px_rgba(239,68,68,0.5)]' : 'bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.5)]';
                                @endphp

                                <div class="w-full bg-[#0B1120] rounded-full h-2 border border-[#2D3748]">
                                    <div class="{{ $color }} h-2 rounded-full transition-all duration-500"
                                        style="width: {{ min($percentage, 100) }}%"></div>
                                </div>

                                @if($product->stock_current <= $product->stock_minimum)
                                    <div
                                        class="mt-4 flex items-start p-3 bg-red-900/20 rounded-lg border border-red-900/50">
                                        <svg class="w-5 h-5 text-red-400 mr-2 flex-shrink-0" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                            </path>
                                        </svg>
                                        <div>
                                            <p class="text-xs font-bold text-red-400">Critical Low Stock!</p>
                                            <p class="text-[10px] text-red-300/70 mt-0.5">Immediate restock required to
                                                maintain operations.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- 3. KARTU AKSI CEPAT --}}
                        <div class="bg-[#151B2D] shadow-xl sm:rounded-2xl overflow-hidden border border-[#2D3748] p-6">
                            <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Quick Actions</h4>
                            <div class="flex flex-col gap-3">

                                {{-- TOMBOL RESTOCK (HANYA MANAGER & LOW STOCK) --}}
                                @if(Auth::user()->role === 'manager' && $product->stock_current <= $product->stock_minimum)
                                    <a href="{{ route('restock.create') }}"
                                        class="w-full flex items-center justify-center px-4 py-3 bg-green-600 text-white font-bold text-sm rounded-lg hover:bg-green-700 transition shadow-lg shadow-green-600/20 border border-transparent animate-pulse">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Create Restock Order
                                    </a>
                                @endif

                                <a href="{{ route('products.edit', $product) }}"
                                    class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 text-white font-bold text-sm rounded-lg hover:bg-blue-700 transition shadow-lg shadow-blue-600/20 border border-transparent">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                    Edit Component
                                </a>

                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                    onsubmit="return confirm('Are you sure? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full flex items-center justify-center px-4 py-3 bg-[#0B1120] text-red-400 font-bold text-sm rounded-lg border border-red-900/30 hover:bg-red-900/20 hover:border-red-500/50 transition">
                                        Delete Component
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>