<x-app-layout>
    {{-- Override background default --}}
    <div class="min-h-screen bg-[#0B1120] text-gray-300 font-sans">

        <x-slot name="header">
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Alert Messages --}}
                @if(session('success'))
                    <div
                        class="mb-6 p-4 bg-[#064E3B] border border-[#059669] text-green-100 rounded-lg flex items-center shadow-lg shadow-green-900/20">
                        <svg class="w-5 h-5 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="font-bold mr-1">Success!</span> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div
                        class="mb-6 p-4 bg-[#7F1D1D] border border-[#B91C1C] text-red-100 rounded-lg flex items-center shadow-lg shadow-red-900/20">
                        <svg class="w-5 h-5 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-bold mr-1">Error!</span> {{ session('error') }}
                    </div>
                @endif

                {{-- CARD UTAMA --}}
                <div class="bg-[#151B2D] shadow-2xl sm:rounded-2xl overflow-hidden border border-[#2D3748]">

                    {{-- HEADER --}}
                    <div
                        class="p-6 border-b border-[#2D3748] flex flex-col md:flex-row justify-between items-center bg-[#151B2D] gap-4">
                        <div>
                            <h3 class="text-2xl font-black text-white tracking-tight">Transaction History</h3>
                            <p class="text-sm font-medium text-gray-400 mt-1">Monitor incoming and outgoing stock
                                movements.</p>
                        </div>

                        {{-- Tombol Tambah --}}
                        @if(Auth::user()->role !== 'supplier')
                            <a href="{{ route('transactions.create') }}"
                                class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow-lg shadow-blue-600/20 border border-transparent transition-all transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                New Transaction
                            </a>
                        @endif
                    </div>

                    {{-- TABEL --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#2D3748]">
                            <thead class="bg-[#1A202C]">
                                <tr>
                                    {{-- HEADER RATA TENGAH (text-center) --}}
                                    <th scope="col"
                                        class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-[#2D3748]">
                                        TRX Code</th>
                                    <th scope="col"
                                        class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-[#2D3748]">
                                        Type</th>
                                    <th scope="col"
                                        class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-[#2D3748]">
                                        Date</th>
                                    <th scope="col"
                                        class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-[#2D3748]">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-[#2D3748]">
                                        Total Items</th>
                                    <th scope="col"
                                        class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[#151B2D] divide-y divide-[#2D3748]">
                                @forelse ($transactions as $trx)
                                    <tr class="hover:bg-[#1F2937] transition duration-150 group">

                                        {{-- TRX CODE (Tengah) --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-[#2D3748]">
                                            <div class="flex flex-col items-center justify-center">
                                                <div
                                                    class="text-sm font-black text-white font-mono group-hover:text-blue-400 transition">
                                                    {{ $trx->transaction_number }}</div>
                                                <div class="text-xs text-gray-500 mt-1 flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                        </path>
                                                    </svg>
                                                    {{ $trx->creator->name ?? 'Unknown' }}
                                                </div>
                                            </div>
                                        </td>

                                        {{-- TYPE (Tengah) --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-[#2D3748]">
                                            <div class="flex flex-col items-center justify-center w-full">
                                                @if($trx->type === 'incoming')
                                                    <span
                                                        class="px-3 py-1 inline-flex items-center text-xs font-bold rounded-full bg-blue-900/30 text-blue-400 border border-blue-800">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                                        </svg>
                                                        INCOMING
                                                    </span>
                                                    <div class="text-[10px] text-gray-500 mt-1 font-medium pl-1">From:
                                                        {{ $trx->supplier->name ?? '-' }}</div>
                                                @else
                                                    <span
                                                        class="px-3 py-1 inline-flex items-center text-xs font-bold rounded-full bg-orange-900/30 text-orange-400 border border-orange-800">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                                        </svg>
                                                        OUTGOING
                                                    </span>
                                                    <div class="text-[10px] text-gray-500 mt-1 font-medium pl-1">To:
                                                        {{ $trx->customer_name ?? '-' }}</div>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- DATE (Tengah) --}}
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-300 font-medium border-r border-[#2D3748]">
                                            {{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }}
                                        </td>

                                        {{-- STATUS (Tengah) --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-[#2D3748]">
                                            <div class="flex justify-center w-full">
                                                @if($trx->status === 'pending')
                                                    <span
                                                        class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-yellow-900/30 text-yellow-400 border border-yellow-800 animate-pulse">
                                                        PENDING
                                                    </span>
                                                @elseif($trx->status === 'approved')
                                                    <span
                                                        class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-green-900/30 text-green-400 border border-green-800">
                                                        APPROVED
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-gray-700 text-gray-300 border border-gray-600">
                                                        {{ strtoupper($trx->status) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- TOTAL ITEMS (Tengah) --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-[#2D3748]">
                                            <div class="text-sm font-bold text-white">{{ $trx->products_count ?? 0 }} <span
                                                    class="text-gray-500 font-normal">Items</span></div>
                                        </td>

                                        {{-- ACTION (Tengah) --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center space-x-2 w-full">
                                                {{-- Detail --}}
                                                <a href="{{ route('transactions.show', $trx) }}"
                                                    class="p-2 bg-[#1A202C] border border-[#374151] rounded-lg text-gray-400 hover:text-blue-400 hover:border-blue-500/50 transition shadow-sm"
                                                    title="View Details">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                        </path>
                                                    </svg>
                                                </a>

                                                {{-- Hapus --}}
                                                @if($trx->status === 'pending' && (Auth::user()->id === $trx->created_by_user_id || Auth::user()->role === 'admin'))
                                                    <form action="{{ route('transactions.destroy', $trx) }}" method="POST"
                                                        class="inline-block"
                                                        onsubmit="return confirm('Are you sure? This action cannot be undone.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="p-2 bg-[#1A202C] border border-[#374151] rounded-lg text-gray-400 hover:text-red-400 hover:border-red-500/50 transition shadow-sm"
                                                            title="Delete">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-500">
                                                <svg class="w-16 h-16 mb-4 text-gray-700" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                                    </path>
                                                </svg>
                                                <p class="text-lg font-medium text-gray-400">No transactions recorded</p>
                                                @if(Auth::user()->role !== 'supplier')
                                                    <a href="{{ route('transactions.create') }}"
                                                        class="mt-4 text-blue-500 hover:text-blue-400 font-medium hover:underline">Create
                                                        new transaction &rarr;</a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Footer Pagination (Dark) --}}
                    <div class="px-6 py-4 bg-[#1A202C] border-t border-[#2D3748]">
                        {{ $transactions->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>