<x-app-layout>
    <div class="min-h-screen bg-[#0B1120] text-gray-300 font-sans">
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Alert Messages --}}
                @if(session('success'))
                    <div class="mb-6 p-4 bg-[#064E3B] border border-[#059669] text-green-100 rounded-lg flex items-center shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="font-bold mr-1">Success!</span> {{ session('success') }}
                    </div>
                @endif

                <div class="bg-[#151B2D] shadow-2xl sm:rounded-2xl overflow-hidden border border-[#2D3748]">
                    
                    {{-- HEADER HALAMAN --}}
                    <div class="p-6 border-b border-[#2D3748] bg-[#151B2D]">
                        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                            <div>
                                <h3 class="text-2xl font-black text-white tracking-tight">Transaction History</h3>
                                <p class="text-sm font-medium text-gray-400 mt-1">Monitor stock movements.</p>
                            </div>
                            
                            @if(Auth::user()->role !== 'supplier')
                                <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow-lg transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    New Transaction
                                </a>
                            @endif
                        </div>

                        {{-- TABS & FILTER BAR --}}
                        <div class="flex flex-col md:flex-row justify-between items-end gap-4">
                            
                            {{-- TABS (Incoming vs Outgoing) --}}
                            <div class="flex bg-[#0B1120] p-1 rounded-lg border border-[#2D3748]">
                                <a href="{{ route('transactions.index') }}" 
                                class="px-4 py-2 text-sm font-bold rounded-md transition {{ !request('type') ? 'bg-[#1F2937] text-white shadow' : 'text-gray-500 hover:text-gray-300' }}">
                                    All
                                </a>
                                <a href="{{ route('transactions.index', ['type' => 'incoming']) }}" 
                                class="px-4 py-2 text-sm font-bold rounded-md transition {{ request('type') == 'incoming' ? 'bg-blue-900/50 text-blue-400 border border-blue-800 shadow' : 'text-gray-500 hover:text-gray-300' }}">
                                    Incoming
                                </a>
                                <a href="{{ route('transactions.index', ['type' => 'outgoing']) }}" 
                                class="px-4 py-2 text-sm font-bold rounded-md transition {{ request('type') == 'outgoing' ? 'bg-orange-900/50 text-orange-400 border border-orange-800 shadow' : 'text-gray-500 hover:text-gray-300' }}">
                                    Outgoing
                                </a>
                            </div>

                            {{-- FORM FILTER (Search & Date) --}}
                            <form method="GET" action="{{ route('transactions.index') }}" class="flex gap-2 w-full md:w-auto">
                                {{-- Pertahankan Tab saat filter --}}
                                @if(request('type')) <input type="hidden" name="type" value="{{ request('type') }}"> @endif

                                {{-- Filter Status --}}
                                <select name="status" class="rounded-lg border-[#4A5568] bg-[#0B1120] text-gray-300 text-sm py-2 focus:border-blue-500 focus:ring-blue-500" onchange="this.form.submit()">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                </select>

                                {{-- Filter Tanggal --}}
                                <input type="date" name="date" value="{{ request('date') }}" class="rounded-lg border-[#4A5568] bg-[#0B1120] text-gray-300 text-sm py-2 focus:border-blue-500 focus:ring-blue-500" onchange="this.form.submit()">

                                {{-- Search --}}
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search TRX..." class="pl-3 pr-8 py-2 rounded-lg border-[#4A5568] bg-[#0B1120] text-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500 w-32 md:w-48">
                                    <button type="submit" class="absolute right-2 top-2.5 text-gray-500 hover:text-white">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- TABEL DATA --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#2D3748]">
                            <thead class="bg-[#1A202C]">
                                <tr>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase border-r border-[#2D3748]">TRX Code</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase border-r border-[#2D3748]">Type</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase border-r border-[#2D3748]">Date</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase border-r border-[#2D3748]">Status</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase border-r border-[#2D3748]">Items</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[#151B2D] divide-y divide-[#2D3748]">
                                @forelse ($transactions as $trx)
                                    <tr class="hover:bg-[#1F2937] transition duration-150">
                                        <td class="px-6 py-4 text-center border-r border-[#2D3748]">
                                            <span class="text-sm font-black text-white font-mono">{{ $trx->transaction_number }}</span>
                                            <div class="text-xs text-gray-500 mt-1">{{ $trx->creator->name ?? 'Unknown' }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-center border-r border-[#2D3748]">
                                            @if($trx->type === 'incoming')
                                                <span class="px-2 py-1 text-xs font-bold rounded bg-blue-900/30 text-blue-400 border border-blue-800">INCOMING</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-bold rounded bg-orange-900/30 text-orange-400 border border-orange-800">OUTGOING</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm text-gray-300 border-r border-[#2D3748]">
                                            {{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-center border-r border-[#2D3748]">
                                            @if($trx->status === 'pending')
                                                <span class="px-2 py-1 text-xs font-bold rounded bg-yellow-900/30 text-yellow-400 border border-yellow-800 animate-pulse">PENDING</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-bold rounded bg-green-900/30 text-green-400 border border-green-800">APPROVED</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center text-white font-bold border-r border-[#2D3748]">
                                            {{ $trx->products_count }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('transactions.show', $trx) }}" class="p-2 bg-[#1A202C] border border-[#374151] rounded text-gray-400 hover:text-blue-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </a>
                                                
                                                @if($trx->status === 'pending')
                                                    <a href="{{ route('transactions.edit', $trx) }}" class="p-2 bg-[#1A202C] border border-[#374151] rounded text-amber-500 hover:text-amber-400">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                    </a>
                                                    
                                                    @if((Auth::user()->id === $trx->created_by_user_id || Auth::user()->role === 'admin'))
                                                        <form action="{{ route('transactions.destroy', $trx) }}" method="POST" class="inline" onsubmit="return confirm('Delete?');">
                                                            @csrf @method('DELETE')
                                                            <button class="p-2 bg-[#1A202C] border border-[#374151] rounded text-red-500 hover:text-red-400">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">No transactions found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="px-6 py-4 bg-[#1A202C] border-t border-[#2D3748]">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>