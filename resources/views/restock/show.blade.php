<x-app-layout>
    <div class="min-h-screen bg-[#0B1120] text-gray-300 font-sans">
        
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                
                {{-- TOMBOL KEMBALI --}}
                <a href="{{ route('restock.index') }}" class="inline-flex items-center mb-6 text-sm font-medium text-gray-500 hover:text-gray-300 transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
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
                    <div>
                        @if($restockOrder->status == 'pending')
                            <span class="px-4 py-2 rounded-lg bg-yellow-900/30 border border-yellow-700 text-yellow-400 font-bold text-sm animate-pulse">
                                ⚠ WAITING APPROVAL
                            </span>
                        @elseif($restockOrder->status == 'confirmed')
                            <span class="px-4 py-2 rounded-lg bg-blue-900/30 border border-blue-700 text-blue-400 font-bold text-sm">
                                ✓ CONFIRMED
                            </span>
                        @elseif($restockOrder->status == 'shipped')
                            <span class="px-4 py-2 rounded-lg bg-purple-900/30 border border-purple-700 text-purple-400 font-bold text-sm flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                ✈ IN TRANSIT
                            </span>
                        @elseif($restockOrder->status == 'received')
                            <span class="px-4 py-2 rounded-lg bg-green-900/30 border border-green-700 text-green-400 font-bold text-sm">
                                ✓ RECEIVED
                            </span>
                        @elseif($restockOrder->status == 'rejected')
                            <span class="px-4 py-2 rounded-lg bg-red-900/30 border border-red-700 text-red-400 font-bold text-sm">
                                ✕ REJECTED
                            </span>
                        @endif
                    </div>
                </div>

                {{-- === VISUAL TIMELINE === --}}
                @if($restockOrder->status !== 'rejected')
                    @php
                        // Tentukan Level Progres (0 - 3)
                        $steps = ['pending', 'confirmed', 'shipped', 'received'];
                        $currentLevel = array_search($restockOrder->status, $steps);
                        if ($currentLevel === false) $currentLevel = -1; 
                    @endphp

                    <div class="mb-8 bg-[#151B2D] p-6 rounded-2xl border border-[#2D3748] shadow-lg">
                        <div class="relative flex items-center justify-between w-full">
                            {{-- Garis Latar (Abu-abu) --}}
                            <div class="absolute top-1/2 left-0 w-full h-1 bg-[#2D3748] -z-0 rounded"></div>
                            
                            {{-- Garis Progres (Hijau/Biru) --}}
                            <div class="absolute top-1/2 left-0 h-1 bg-blue-600 transition-all duration-1000 -z-0 rounded" 
                                 style="width: {{ $currentLevel * 33 }}%"></div>

                            {{-- Step 1: Pending --}}
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs border-2 
                                    {{ $currentLevel >= 0 ? 'bg-blue-600 border-blue-600 text-white' : 'bg-[#151B2D] border-gray-500 text-gray-500' }}">
                                    1
                                </div>
                                <span class="mt-2 text-xs font-bold {{ $currentLevel >= 0 ? 'text-blue-400' : 'text-gray-500' }}">Pending</span>
                            </div>

                            {{-- Step 2: Confirmed --}}
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs border-2 
                                    {{ $currentLevel >= 1 ? 'bg-blue-600 border-blue-600 text-white' : 'bg-[#151B2D] border-gray-500 text-gray-500' }}">
                                    2
                                </div>
                                <span class="mt-2 text-xs font-bold {{ $currentLevel >= 1 ? 'text-blue-400' : 'text-gray-500' }}">Confirmed</span>
                            </div>

                            {{-- Step 3: Shipped --}}
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs border-2 
                                    {{ $currentLevel >= 2 ? 'bg-blue-600 border-blue-600 text-white' : 'bg-[#151B2D] border-gray-500 text-gray-500' }}">
                                    3
                                </div>
                                <span class="mt-2 text-xs font-bold {{ $currentLevel >= 2 ? 'text-blue-400' : 'text-gray-500' }}">In Transit</span>
                            </div>

                            {{-- Step 4: Received --}}
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs border-2 
                                    {{ $currentLevel >= 3 ? 'bg-green-500 border-green-500 text-white' : 'bg-[#151B2D] border-gray-500 text-gray-500' }}">
                                    4
                                </div>
                                <span class="mt-2 text-xs font-bold {{ $currentLevel >= 3 ? 'text-green-400' : 'text-gray-500' }}">Received</span>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- === END TIMELINE === --}}

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- KOLOM KIRI: DETAIL ITEM --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-[#151B2D] shadow-2xl sm:rounded-2xl overflow-hidden border border-[#2D3748]">
                            <div class="px-6 py-4 border-b border-[#2D3748] bg-[#1A202C] flex justify-between items-center">
                                <h3 class="font-bold text-white">Order Items</h3>
                                <span class="text-xs font-mono text-gray-500">{{ $restockOrder->products->count() }} Items</span>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-[#2D3748]">
                                    <thead class="bg-[#0B1120]">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase">Product</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase">SKU</th>
                                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#2D3748]">
                                        @foreach($restockOrder->products as $product)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        @if($product->image_path)
                                                            <img src="{{ Storage::url($product->image_path) }}" class="h-10 w-10 rounded object-cover border border-[#4A5568] mr-3">
                                                        @else
                                                            <div class="h-10 w-10 rounded bg-[#2D3748] flex items-center justify-center text-[10px] text-gray-500 mr-3 border border-[#4A5568]">IMG</div>
                                                        @endif
                                                        <div class="text-sm font-bold text-white">{{ $product->name }}</div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 font-mono">
                                                    {{ $product->sku }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <span class="font-black text-white text-lg">{{ $product->pivot->quantity }}</span>
                                                    <span class="text-xs text-gray-500 ml-1">{{ $product->unit }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="bg-[#151B2D] shadow-xl sm:rounded-2xl border border-[#2D3748] p-6">
                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Notes from Manager</h4>
                            <p class="text-sm text-gray-300 italic">"{{ $restockOrder->notes ?? 'No notes provided.' }}"</p>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: INFO & AKSI --}}
                    <div class="space-y-6">
                        
                        {{-- KARTU INFO --}}
                        <div class="bg-[#151B2D] shadow-xl sm:rounded-2xl border border-[#2D3748] p-6">
                            <h4 class="text-sm font-bold text-white mb-4 border-b border-[#2D3748] pb-2">Order Details</h4>
                            <div class="space-y-4">
                                <div>
                                    <span class="text-xs text-gray-500 uppercase block">Supplier</span>
                                    <span class="text-white font-bold text-lg">{{ $restockOrder->supplier->name ?? '-' }}</span>
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

                        {{-- AKSI SUPPLIER --}}
                        @if(Auth::user()->role === 'supplier' && strtolower(trim($restockOrder->status)) == 'pending')
                            <div class="bg-[#151B2D] shadow-xl sm:rounded-2xl border border-blue-700/50 p-6 relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-16 h-16 bg-blue-500/10 rounded-bl-full -mr-4 -mt-4"></div>
                                <h4 class="text-blue-400 font-bold text-lg mb-2">Supplier Action</h4>
                                <p class="text-xs text-gray-400 mb-6">Please review the order. Take action below.</p>
                                
                                <div class="flex gap-3">
                                    <form action="{{ route('restock.reject', $restockOrder) }}" method="POST" class="flex-1">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="w-full flex justify-center items-center px-4 py-3 bg-[#1A202C] border border-red-500/50 text-red-500 font-bold rounded-lg hover:bg-red-900/20 transition" onclick="return confirm('Reject this order?');">
                                            Reject
                                        </button>
                                    </form>
                                    <form action="{{ route('restock.confirm', $restockOrder) }}" method="POST" class="flex-1">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="w-full flex justify-center items-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg transition transform hover:-translate-y-0.5" onclick="return confirm('Confirm this order?');">
                                            Confirm
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        {{-- AKSI MANAGER --}}
                        @if(Auth::user()->role === 'manager')

                            @if($restockOrder->status === 'confirmed')
                                <div class="bg-[#151B2D] shadow-xl sm:rounded-2xl border border-purple-700/50 p-6">
                                    <h4 class="text-purple-400 font-bold text-lg mb-2">Update Tracking</h4>
                                    <p class="text-xs text-gray-400 mb-4">Supplier has confirmed. Mark as shipped when ready.</p>
                                    <form action="{{ route('restock.update-status', $restockOrder) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="shipped">
                                        <button type="submit" class="w-full flex justify-center items-center px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-lg shadow-lg transition">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            Start Shipment (In Transit)
                                        </button>
                                    </form>
                                </div>

                            @elseif($restockOrder->status === 'shipped')
                                <div class="bg-[#151B2D] shadow-xl sm:rounded-2xl border border-green-700/50 p-6">
                                    <h4 class="text-green-400 font-bold text-lg mb-2">Receive Order</h4>
                                    <p class="text-xs text-gray-400 mb-4">Mark as received when it arrives.</p>
                                    <form action="{{ route('restock.update-status', $restockOrder) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="received">
                                        <button type="submit" class="w-full flex justify-center items-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-lg transition" onclick="return confirm('Mark as received?');">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Mark as Received
                                        </button>
                                    </form>
                                </div>
                            @endif

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>