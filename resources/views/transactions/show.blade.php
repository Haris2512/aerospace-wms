<x-app-layout>
    <div class="min-h-screen bg-[#0B1120] text-gray-300 font-sans">
        
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                
                {{-- TOMBOL KEMBALI --}}
                <a href="{{ route('transactions.index') }}" class="inline-flex items-center mb-6 text-sm font-medium text-gray-500 hover:text-gray-300 transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Transactions
                </a>

                {{-- HEADER & STATUS --}}
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                    <div>
                        <h2 class="font-black text-3xl text-white leading-tight">
                            {{ $transaction->transaction_number }}
                        </h2>
                        <p class="text-gray-400 text-sm mt-1">Created on {{ $transaction->created_at->format('d M Y, H:i') }} by {{ $transaction->creator->name }}</p>
                    </div>

                    {{-- STATUS BADGE --}}
                    @if($transaction->status === 'pending')
                        <div class="px-4 py-2 rounded-lg bg-yellow-900/30 border border-yellow-700 text-yellow-400 font-bold text-sm animate-pulse">
                            ⚠ WAITING APPROVAL
                        </div>
                    @elseif($transaction->status === 'approved')
                        <div class="px-4 py-2 rounded-lg bg-green-900/30 border border-green-700 text-green-400 font-bold text-sm flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            APPROVED by {{ $transaction->approver->name ?? 'Manager' }}
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- KOLOM KIRI: DETAIL ITEM --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-[#151B2D] shadow-2xl sm:rounded-2xl overflow-hidden border border-[#2D3748]">
                            <div class="px-6 py-4 border-b border-[#2D3748] bg-[#1A202C] flex justify-between items-center">
                                <h3 class="font-bold text-white">Transaction Items</h3>
                                <span class="text-xs font-mono text-gray-500">{{ $transaction->products->count() }} Items</span>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-[#2D3748]">
                                    <thead class="bg-[#0B1120]">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase">Product</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase">Category</th>
                                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase">Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#2D3748]">
                                        @foreach($transaction->products as $product)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        @if($product->image_path)
                                                            <img src="{{ Storage::url($product->image_path) }}" class="h-10 w-10 rounded object-cover border border-[#4A5568] mr-3">
                                                        @else
                                                            <div class="h-10 w-10 rounded bg-[#2D3748] flex items-center justify-center text-[10px] text-gray-500 mr-3 border border-[#4A5568]">IMG</div>
                                                        @endif
                                                        <div>
                                                            <div class="text-sm font-bold text-white">{{ $product->name }}</div>
                                                            <div class="text-xs font-mono text-gray-500">{{ $product->sku }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                                    {{ $product->category->name ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <span class="font-black text-white text-lg">{{ $product->pivot->quantity }}</span>
                                                    <span class="text-xs text-gray-500">{{ $product->unit }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- NOTES --}}
                        <div class="bg-[#151B2D] shadow-xl sm:rounded-2xl border border-[#2D3748] p-6">
                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Notes</h4>
                            <p class="text-sm text-gray-300 italic">"{{ $transaction->notes ?? 'No additional notes.' }}"</p>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: INFO & AKSI --}}
                    <div class="space-y-6">
                        
                        {{-- KARTU INFO --}}
                        <div class="bg-[#151B2D] shadow-xl sm:rounded-2xl border border-[#2D3748] p-6">
                            <h4 class="text-sm font-bold text-white mb-4 border-b border-[#2D3748] pb-2">Details</h4>
                            
                            <div class="space-y-4">
                                <div>
                                    <span class="text-xs text-gray-500 uppercase block">Transaction Type</span>
                                    @if($transaction->type == 'incoming')
                                        <span class="inline-flex items-center text-blue-400 font-bold">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                            Incoming Stock
                                        </span>
                                    @else
                                        <span class="inline-flex items-center text-orange-400 font-bold">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                            Outgoing Stock
                                        </span>
                                    @endif
                                </div>

                                <div>
                                    <span class="text-xs text-gray-500 uppercase block">Date</span>
                                    <span class="text-white font-medium">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d F Y') }}</span>
                                </div>

                                @if($transaction->type == 'incoming')
                                    <div>
                                        <span class="text-xs text-gray-500 uppercase block">Supplier</span>
                                        <span class="text-white font-bold">{{ $transaction->supplier->name ?? '-' }}</span>
                                    </div>
                                @else
                                    <div>
                                        <span class="text-xs text-gray-500 uppercase block">Customer / Destination</span>
                                        <span class="text-white font-bold">{{ $transaction->customer_name ?? '-' }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- KARTU APPROVAL (Hanya muncul jika PENDING dan User adalah MANAGER) --}}
                        @if($transaction->status === 'pending' && Auth::user()->role === 'manager')
                            <div class="bg-[#151B2D] shadow-xl sm:rounded-2xl border border-yellow-700/50 p-6 relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-16 h-16 bg-yellow-500/10 rounded-bl-full -mr-4 -mt-4"></div>
                                
                                <h4 class="text-yellow-500 font-bold text-lg mb-2">Action Required</h4>
                                <p class="text-xs text-gray-400 mb-6">This transaction is pending. Approving it will update the master stock permanently.</p>
                                
                                <form action="{{ route('transactions.approve', $transaction) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex justify-center items-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-lg transition transform hover:-translate-y-0.5" onclick="return confirm('Are you sure? Stock will be updated.')">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Approve & Update Stock
                                    </button>
                                </form>
                                
                                <div class="mt-3 text-center">
                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs text-red-500 hover:text-red-400 underline" onclick="return confirm('Reject and delete this transaction record?')">
                                            Reject / Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>