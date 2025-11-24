<x-app-layout>
    <div class="min-h-screen bg-[#0B1120] text-gray-300 font-sans">

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

                {{-- TOMBOL KEMBALI --}}
                <a href="{{ route('restock.index') }}"
                    class="inline-flex items-center mb-6 text-sm font-medium text-gray-500 hover:text-gray-300 transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Orders
                </a>

                {{-- HEADER & STATUS --}}
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                    <div>
                        <h2 class="font-black text-3xl text-white leading-tight">
                            {{ $restockOrder->po_number }}
                        </h2>
                        <p class="text-gray-400 text-sm mt-1">
                            Ordered on {{ \Carbon\Carbon::parse($restockOrder->order_date)->format('d F Y') }}
                        </p>
                    </div>

                    {{-- STATUS BADGE --}}
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-900/30 border-yellow-700 text-yellow-400',
                            'confirmed' => 'bg-blue-900/30 border-blue-700 text-blue-400',
                            'shipped' => 'bg-purple-900/30 border-purple-700 text-purple-400',
                            'received' => 'bg-green-900/30 border-green-700 text-green-400',
                        ];
                        $color = $statusColors[$restockOrder->status] ?? 'bg-gray-700 border-gray-600 text-gray-300';
                    @endphp

                    <div class="px-4 py-2 rounded-lg border {{ $color }} font-bold text-sm uppercase tracking-wider">
                        {{ $restockOrder->status }}
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- KOLOM KIRI: DETAIL ITEM --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- Tabel Barang --}}
                        <div class="bg-[#151B2D] shadow-2xl sm:rounded-2xl overflow-hidden border border-[#2D3748]">
                            <div
                                class="px-6 py-4 border-b border-[#2D3748] bg-[#1A202C] flex justify-between items-center">
                                <h3 class="font-bold text-white">Order Items</h3>
                                <span class="text-xs font-mono text-gray-500">{{ $restockOrder->products->count() }}
                                    Items</span>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-[#2D3748]">
                                    <thead class="bg-[#0B1120]">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase">
                                                Product</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase">
                                                SKU</th>
                                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase">
                                                Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#2D3748]">
                                        @foreach($restockOrder->products as $product)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        @if($product->image_path)
                                                            <img src="{{ Storage::url($product->image_path) }}"
                                                                class="h-10 w-10 rounded object-cover border border-[#4A5568] mr-3">
                                                        @else
                                                            <div
                                                                class="h-10 w-10 rounded bg-[#2D3748] flex items-center justify-center text-[10px] text-gray-500 mr-3 border border-[#4A5568]">
                                                                IMG</div>
                                                        @endif
                                                        <div class="text-sm font-bold text-white">{{ $product->name }}</div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 font-mono">
                                                    {{ $product->sku }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <span
                                                        class="font-black text-white text-lg">{{ $product->pivot->quantity }}</span>
                                                    <span class="text-xs text-gray-500 ml-1">{{ $product->unit }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div class="bg-[#151B2D] shadow-xl sm:rounded-2xl border border-[#2D3748] p-6">
                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Notes from Manager
                            </h4>
                            <p class="text-sm text-gray-300 italic">"{{ $restockOrder->notes ?? 'No notes provided.' }}"
                            </p>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: INFO & AKSI --}}
                    <div class="space-y-6">

                        {{-- Kartu Info --}}
                        <div class="bg-[#151B2D] shadow-xl sm:rounded-2xl border border-[#2D3748] p-6">
                            <h4 class="text-sm font-bold text-white mb-4 border-b border-[#2D3748] pb-2">Order Details
                            </h4>

                            <div class="space-y-4">
                                <div>
                                    <span class="text-xs text-gray-500 uppercase block">Supplier</span>
                                    <span
                                        class="text-white font-bold text-lg">{{ $restockOrder->supplier->name ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 uppercase block">Created By</span>
                                    <span class="text-gray-300">{{ $restockOrder->creator->name ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500 uppercase block">Expected Delivery</span>
                                    <span class="text-blue-400 font-medium">
                                        {{ $restockOrder->expected_delivery_date ? \Carbon\Carbon::parse($restockOrder->expected_delivery_date)->format('d F Y') : 'Not set' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- KARTU AKSI SUPPLIER --}}
                        @if(Auth::user()->role === 'supplier' && $restockOrder->status === 'pending')
                            <div
                                class="bg-[#151B2D] shadow-xl sm:rounded-2xl border border-blue-700/50 p-6 relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-16 h-16 bg-blue-500/10 rounded-bl-full -mr-4 -mt-4">
                                </div>

                                <h4 class="text-blue-400 font-bold text-lg mb-2">Supplier Action</h4>
                                <p class="text-xs text-gray-400 mb-6">Please review the order items above. Click confirm to
                                    accept this PO.</p>

                                {{-- Tombol Confirm (Update Status ke 'confirmed') --}}
                                {{-- NOTE: Kita perlu buat route khusus untuk update status ini nanti di Controller --}}
                                <button type="button"
                                    class="w-full flex justify-center items-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg transition transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Confirm Order
                                </button>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>