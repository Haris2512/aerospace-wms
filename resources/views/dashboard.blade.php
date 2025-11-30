<x-app-layout>
    <div class="min-h-screen bg-[#0B1120] text-gray-300 font-sans">

        {{-- HEADER --}}
        <div class="bg-[#151B2D] border-b border-[#2D3748] shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="font-black text-2xl text-white uppercase tracking-wide">
                            Mission Control Center
                        </h2>
                        <p class="text-sm text-gray-400 mt-1">Welcome back, <span
                                class="text-blue-400 font-bold">{{ Auth::user()->name }}</span>
                            ({{ ucfirst(Auth::user()->role) }})</p>
                    </div>
                    <div class="hidden md:block">
                        <span
                            class="px-3 py-1 rounded-full bg-[#0B1120] border border-[#2D3748] text-xs text-gray-500 font-mono">
                            {{ now()->format('d M Y | H:i') }} UTC
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- ========================================== --}}
                {{-- TAMPILAN UNTUK ADMIN & MANAGER --}}
                {{-- ========================================== --}}
                @if(in_array(Auth::user()->role, ['admin', 'manager']))

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        {{-- Card 1: Total Products --}}
                        <div
                            class="bg-[#151B2D] p-6 rounded-2xl border border-[#2D3748] shadow-xl relative overflow-hidden group">
                            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition">
                                <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Components</p>
                            <p class="text-3xl font-black text-white mt-2">{{ $data['total_products'] }}</p>
                        </div>

                        {{-- Card 2: Asset Value --}}
                        <div
                            class="bg-[#151B2D] p-6 rounded-2xl border border-[#2D3748] shadow-xl relative overflow-hidden group">
                            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition">
                                <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Asset Value</p>
                            <p class="text-xl font-black text-green-400 mt-2">Rp
                                {{ number_format($data['total_value'], 0, ',', '.') }}</p>
                        </div>

                        {{-- Card 3: Low Stock (Alert) --}}
                        <div
                            class="bg-[#151B2D] p-6 rounded-2xl border border-red-900/50 shadow-xl relative overflow-hidden group">
                            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition">
                                <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-red-400 uppercase tracking-wider">Low Stock Alerts</p>
                            <p class="text-3xl font-black text-red-500 mt-2">{{ $data['low_stock_count'] }} <span
                                    class="text-sm font-normal text-red-300">Items</span></p>
                        </div>

                        {{-- Card 4: Transaksi Bulan Ini (BARU!) --}}
                        <div
                            class="bg-[#151B2D] p-6 rounded-2xl border border-[#2D3748] shadow-xl relative overflow-hidden group">
                            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition">
                                <svg class="w-16 h-16 text-purple-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Transactions (This Month)
                            </p>
                            <p class="text-3xl font-black text-purple-400 mt-2">{{ $data['transactions_month'] }}</p>
                        </div>
                    </div>

                    {{-- INFO TAMBAHAN KHUSUS MANAGER --}}
                    @if(Auth::user()->role === 'manager')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            {{-- Active Restock --}}
                            <div
                                class="bg-[#151B2D] p-6 rounded-2xl border border-blue-900/50 shadow-xl flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-blue-400 uppercase tracking-wider">Active Restock Orders
                                    </p>
                                    <p class="text-sm text-gray-400">Confirmed / In Transit</p>
                                </div>
                                <p class="text-4xl font-black text-blue-500">{{ $data['active_restocks'] }}</p>
                            </div>

                            {{-- Pending Approval --}}
                            <div
                                class="bg-[#151B2D] p-6 rounded-2xl border border-yellow-900/50 shadow-xl flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-yellow-400 uppercase tracking-wider">Pending Approvals</p>
                                    <p class="text-sm text-gray-400">Needs your review</p>
                                </div>
                                <p class="text-4xl font-black text-yellow-500">{{ $data['pending_transactions'] }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        {{-- TABEL LOW STOCK --}}
                        <div class="bg-[#151B2D] rounded-2xl border border-[#2D3748] overflow-hidden shadow-xl">
                            <div class="px-6 py-4 border-b border-[#2D3748] flex justify-between items-center bg-[#1A202C]">
                                <h3 class="font-bold text-white">Critical Stock Levels</h3>
                                <a href="{{ route('products.index', ['stock_status' => 'low_stock']) }}"
                                    class="text-xs text-blue-400 hover:underline">View All</a>
                            </div>
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-gray-400 uppercase bg-[#0B1120]">
                                    <tr>
                                        <th class="px-6 py-3">Product</th>
                                        <th class="px-6 py-3 text-center">Current</th>
                                        <th class="px-6 py-3 text-center">Min</th>
                                        <th class="px-6 py-3 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#2D3748]">
                                    @forelse($data['low_stock_items'] as $item)
                                        <tr class="hover:bg-[#1F2937] transition">
                                            <td class="px-6 py-4 font-medium text-white">{{ $item->name }}</td>
                                            <td class="px-6 py-4 text-center text-red-400 font-bold">{{ $item->stock_current }}
                                            </td>
                                            <td class="px-6 py-4 text-center text-gray-500">{{ $item->stock_minimum }}</td>
                                            <td class="px-6 py-4 text-right">
                                                @if(Auth::user()->role === 'manager')
                                                    <a href="{{ route('restock.create') }}"
                                                        class="text-blue-400 hover:text-blue-300 text-xs">Restock</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Stock levels are
                                                healthy.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- SHORTCUTS --}}
                        <div class="bg-[#151B2D] rounded-2xl border border-[#2D3748] p-6 shadow-xl">
                            <h3 class="font-bold text-white mb-4">Quick Actions</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <a href="{{ route('products.create') }}"
                                    class="flex flex-col items-center justify-center p-4 bg-[#1F2937] rounded-xl border border-[#374151] hover:border-blue-500 hover:bg-[#2D3748] transition group">
                                    <svg class="w-8 h-8 text-blue-500 mb-2 group-hover:scale-110 transition" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    <span class="text-sm font-bold text-gray-300 group-hover:text-white">Add
                                        Component</span>
                                </a>
                                @if(Auth::user()->role === 'manager')
                                    <a href="{{ route('restock.create') }}"
                                        class="flex flex-col items-center justify-center p-4 bg-[#1F2937] rounded-xl border border-[#374151] hover:border-green-500 hover:bg-[#2D3748] transition group">
                                        <svg class="w-8 h-8 text-green-500 mb-2 group-hover:scale-110 transition" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                            </path>
                                        </svg>
                                        <span class="text-sm font-bold text-gray-300 group-hover:text-white">New Restock
                                            PO</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                {{-- ========================================== --}}
                {{-- TAMPILAN UNTUK STAFF GUDANG --}}
                {{-- ========================================== --}}
                @if(Auth::user()->role === 'staff')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-[#151B2D] p-6 rounded-2xl border border-[#2D3748] shadow-xl">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Transactions Today</p>
                            <p class="text-4xl font-black text-white mt-2">{{ $data['transactions_today'] }}</p>
                        </div>
                        <div class="bg-[#151B2D] p-6 rounded-2xl border border-[#2D3748] shadow-xl">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Pending Approval</p>
                            <p class="text-4xl font-black text-yellow-400 mt-2">{{ $data['pending_transactions'] }}</p>
                        </div>
                    </div>

                    <div class="bg-[#151B2D] rounded-2xl border border-[#2D3748] overflow-hidden shadow-xl">
                        <div class="px-6 py-4 border-b border-[#2D3748] bg-[#1A202C] flex justify-between items-center">
                            <h3 class="font-bold text-white">Your Recent Activity</h3>
                            {{-- Tombol Quick Entry (Sesuai Permintaan) --}}
                            <a href="{{ route('transactions.create') }}"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition">
                                + Quick Entry
                            </a>
                        </div>
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-400 uppercase bg-[#0B1120]">
                                <tr>
                                    <th class="px-6 py-3">TRX Code</th>
                                    <th class="px-6 py-3">Type</th>
                                    <th class="px-6 py-3">Date</th>
                                    <th class="px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#2D3748]">
                                @forelse($data['recent_transactions'] as $trx)
                                    <tr class="hover:bg-[#1F2937] transition">
                                        <td class="px-6 py-4 font-mono text-blue-400">{{ $trx->transaction_number }}</td>
                                        <td class="px-6 py-4 text-white uppercase">{{ $trx->type }}</td>
                                        <td class="px-6 py-4 text-gray-400">{{ $trx->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            @if($trx->status == 'pending')
                                                <span class="text-yellow-400 font-bold text-xs">PENDING</span>
                                            @else
                                                <span class="text-green-400 font-bold text-xs">APPROVED</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No activity yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif

                {{-- TAMPILAN UNTUK SUPPLIER --}}
                @if(Auth::user()->role === 'supplier')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-[#151B2D] p-6 rounded-2xl border border-[#2D3748] shadow-xl">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Pending Orders</p>
                            <p class="text-4xl font-black text-blue-400 mt-2">{{ $data['pending_po'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">Waiting for your confirmation</p>
                        </div>
                        <div class="bg-[#151B2D] p-6 rounded-2xl border border-[#2D3748] shadow-xl">
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Completed Deliveries</p>
                            <p class="text-4xl font-black text-green-400 mt-2">{{ $data['completed_po'] }}</p>
                        </div>
                    </div>

                    <div class="bg-[#151B2D] rounded-2xl border border-[#2D3748] overflow-hidden shadow-xl">
                        <div class="px-6 py-4 border-b border-[#2D3748] bg-[#1A202C]">
                            <h3 class="font-bold text-white">Incoming Restock Orders</h3>
                        </div>
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-400 uppercase bg-[#0B1120]">
                                <tr>
                                    <th class="px-6 py-3">PO Number</th>
                                    <th class="px-6 py-3">Order Date</th>
                                    <th class="px-6 py-3">Items</th>
                                    <th class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#2D3748]">
                                @forelse($data['incoming_orders'] as $order)
                                    <tr class="hover:bg-[#1F2937] transition">
                                        <td class="px-6 py-4 font-mono text-white">{{ $order->po_number }}</td>
                                        <td class="px-6 py-4 text-gray-400">
                                            {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                                        <td class="px-6 py-4 text-blue-400">{{ $order->products->count() }} Items</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('restock.show', $order) }}"
                                                class="text-xs bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No new orders.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- TABEL RIWAYAT PENGIRIMAN --}}
                    <div class="mt-8 bg-[#151B2D] rounded-2xl border border-[#2D3748] overflow-hidden shadow-xl">
                        <div class="px-6 py-4 border-b border-[#2D3748] bg-[#1A202C]">
                            <h3 class="font-bold text-gray-400">Delivery History (Received)</h3>
                        </div>
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-500 uppercase bg-[#0B1120]">
                                <tr>
                                    <th class="px-6 py-3">PO Number</th>
                                    <th class="px-6 py-3">Delivered Date</th>
                                    <th class="px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#2D3748]">
                                @forelse($data['delivery_history'] as $order)
                                    <tr class="hover:bg-[#1F2937] transition opacity-70">
                                        <td class="px-6 py-4 font-mono text-gray-300">{{ $order->po_number }}</td>
                                        <td class="px-6 py-4 text-gray-500">{{ $order->updated_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4 text-green-600 font-bold">RECEIVED</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">No history yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>