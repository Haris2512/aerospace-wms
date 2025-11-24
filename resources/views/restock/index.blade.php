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
                            <h3 class="text-2xl font-black text-white tracking-tight">Restock Orders (PO)</h3>
                            <p class="text-sm font-medium text-gray-400 mt-1">Manage purchase orders to suppliers.</p>
                        </div>

                        {{-- Tombol Tambah (Hanya Manager) --}}
                        @if(Auth::user()->role === 'manager')
                            <a href="{{ route('restock.create') }}"
                                class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg shadow-lg shadow-blue-600/20 border border-transparent transition-all transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Create New PO
                            </a>
                        @endif
                    </div>

                    {{-- TABEL --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#2D3748]">
                            <thead class="bg-[#1A202C]">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-[#2D3748]">
                                        PO Number</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-[#2D3748]">
                                        Supplier</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-[#2D3748]">
                                        Order Date</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider border-r border-[#2D3748]">
                                        Status</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[#151B2D] divide-y divide-[#2D3748]">
                                @forelse ($orders as $order)
                                    <tr class="hover:bg-[#1F2937] transition duration-150 group">

                                        {{-- PO Number --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-[#2D3748]">
                                            <div
                                                class="text-sm font-black text-white font-mono group-hover:text-blue-400 transition">
                                                {{ $order->po_number }}</div>
                                            <div class="text-xs text-gray-500 mt-1">Created by:
                                                {{ $order->creator->name ?? 'Unknown' }}</div>
                                        </td>

                                        {{-- Supplier --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-[#2D3748]">
                                            <div class="text-sm font-bold text-gray-300">
                                                {{ $order->supplier->name ?? 'Unknown Supplier' }}</div>
                                        </td>

                                        {{-- Tanggal --}}
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-400 font-medium border-r border-[#2D3748]">
                                            {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}
                                            <div class="text-[10px] text-gray-500 mt-0.5">
                                                Exp:
                                                {{ $order->expected_delivery_date ? \Carbon\Carbon::parse($order->expected_delivery_date)->format('d M Y') : '-' }}
                                            </div>
                                        </td>

                                        {{-- Status --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center border-r border-[#2D3748]">
                                            <div class="flex justify-center w-full">
                                                @if($order->status === 'pending')
                                                    <span
                                                        class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-yellow-900/30 text-yellow-400 border border-yellow-800 animate-pulse">
                                                        PENDING
                                                    </span>
                                                @elseif($order->status === 'confirmed')
                                                    <span
                                                        class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-blue-900/30 text-blue-400 border border-blue-800">
                                                        CONFIRMED
                                                    </span>
                                                @elseif($order->status === 'shipped')
                                                    <span
                                                        class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-purple-900/30 text-purple-400 border border-purple-800">
                                                        IN TRANSIT
                                                    </span>
                                                @elseif($order->status === 'received')
                                                    <span
                                                        class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-green-900/30 text-green-400 border border-green-800">
                                                        RECEIVED
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-gray-700 text-gray-300 border border-gray-600">
                                                        {{ strtoupper($order->status) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <a href="{{ route('restock.show', $order) }}"
                                                class="inline-flex items-center px-3 py-1.5 bg-[#1A202C] border border-[#374151] rounded-lg text-gray-400 hover:text-blue-400 hover:border-blue-500/50 transition shadow-sm text-xs font-bold">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-500">
                                                <svg class="w-16 h-16 mb-4 text-gray-700" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                <p class="text-lg font-medium text-gray-400">No Restock Orders</p>
                                                @if(Auth::user()->role === 'manager')
                                                    <a href="{{ route('restock.create') }}"
                                                        class="mt-4 text-blue-500 hover:text-blue-400 font-medium hover:underline">Create
                                                        your first PO &rarr;</a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Footer Pagination --}}
                    <div class="px-6 py-4 bg-[#1A202C] border-t border-[#2D3748]">
                        {{ $orders->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>