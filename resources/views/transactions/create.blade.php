<x-app-layout>
    <div class="min-h-screen bg-[#0B1120] text-gray-300 font-sans">

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

                {{-- === 1. AREA PESAN ERROR (Di sini posisinya) === --}}
                @if(session('error'))
                    <div
                        class="mb-6 p-4 bg-[#7F1D1D] border border-[#B91C1C] text-red-100 rounded-lg flex items-center shadow-lg shadow-red-900/20 animate-pulse">
                        <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <span class="font-bold block">System Error!</span>
                            <span class="text-sm">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-900/30 border border-red-500/50 text-red-200 rounded-lg shadow-lg">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 mr-2 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            <strong class="font-bold text-lg">Validation Error</strong>
                        </div>
                        <ul class="list-disc list-inside text-sm space-y-1 ml-2 text-red-300">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{-- === END AREA PESAN ERROR === --}}

                {{-- HEADER --}}
                <div class="mb-8 flex justify-between items-center">
                    <div>
                        <h2 class="font-bold text-3xl text-white leading-tight">
                            {{ __('New Transaction') }}
                        </h2>
                        <p class="text-gray-400 text-sm mt-2">Record incoming or outgoing stock movements.</p>
                    </div>
                    <a href="{{ route('transactions.index') }}"
                        class="px-4 py-2 bg-[#1F2937] border border-[#374151] rounded-lg text-gray-300 text-sm font-bold hover:text-white transition">
                        Cancel
                    </a>
                </div>

                {{-- CARD FORM --}}
                <div class="bg-[#151B2D] shadow-2xl sm:rounded-2xl overflow-hidden border border-[#2D3748]">
                    <div class="p-8">

                        <form method="POST" action="{{ route('transactions.store') }}">
                            @csrf

                            {{-- BAGIAN 1: INFO TRANSAKSI --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">

                                {{-- Tipe Transaksi --}}
                                <div>
                                    <x-input-label for="type" :value="__('Transaction Type')"
                                        class="font-bold !text-gray-300" />
                                    <select id="type" name="type"
                                        class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                                        onchange="toggleType()">
                                        <option value="incoming" {{ old('type') == 'incoming' ? 'selected' : '' }}>
                                            Incoming (Barang Masuk)</option>
                                        <option value="outgoing" {{ old('type') == 'outgoing' ? 'selected' : '' }}>
                                            Outgoing (Barang Keluar)</option>
                                    </select>
                                    @error('type') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- Tanggal --}}
                                <div>
                                    <x-input-label for="transaction_date" :value="__('Date')"
                                        class="font-bold !text-gray-300" />
                                    <input id="transaction_date" type="date" name="transaction_date"
                                        value="{{ old('transaction_date', date('Y-m-d')) }}"
                                        class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                                        required />
                                    @error('transaction_date') <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Supplier (Muncul jika Incoming) --}}
                                <div id="supplier_field">
                                    <x-input-label for="supplier_id" :value="__('Supplier')"
                                        class="font-bold !text-gray-300" />
                                    <select id="supplier_id" name="supplier_id"
                                        class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5">
                                        <option value="">-- Select Supplier --</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Customer (Muncul jika Outgoing) --}}
                                <div id="customer_field" class="hidden">
                                    <x-input-label for="customer_name" :value="__('Customer / Destination')"
                                        class="font-bold !text-gray-300" />
                                    <input id="customer_name" type="text" name="customer_name"
                                        value="{{ old('customer_name') }}"
                                        class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                                        placeholder="e.g. Hangar B Maintenance Team" />
                                    @error('customer_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <hr class="border-[#2D3748] mb-8">

                            {{-- BAGIAN 2: DAFTAR PRODUK (DYNAMIC) --}}
                            <div class="mb-4 flex justify-between items-center">
                                <h3 class="text-lg font-bold text-white">Items List</h3>
                                <button type="button" onclick="addProductRow()"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-lg transition">
                                    + Add Item
                                </button>
                            </div>

                            <div class="bg-[#1A202C] rounded-xl border border-[#2D3748] overflow-hidden mb-6">
                                <table class="min-w-full divide-y divide-[#2D3748]">
                                    <thead class="bg-[#0B1120]">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-400 uppercase">
                                                Product</th>
                                            <th
                                                class="px-4 py-3 text-left text-xs font-bold text-gray-400 uppercase w-32">
                                                Quantity</th>
                                            <th
                                                class="px-4 py-3 text-right text-xs font-bold text-gray-400 uppercase w-20">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="product_rows" class="divide-y divide-[#2D3748]">
                                        {{-- Baris Pertama (Default) --}}
                                        <tr id="row_0">
                                            <td class="px-4 py-3">
                                                <select name="products[0][id]"
                                                    class="w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white text-sm focus:border-blue-500 focus:ring-blue-500"
                                                    required>
                                                    <option value="">-- Select Component --</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}">
                                                            {{ $product->sku }} - {{ $product->name }} (Stock:
                                                            {{ $product->stock_current }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="number" name="products[0][quantity]"
                                                    class="w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white text-sm focus:border-blue-500 focus:ring-blue-500"
                                                    min="1" value="1" required>
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <button type="button" onclick="removeRow(0)"
                                                    class="text-red-500 hover:text-red-400">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                @if($errors->has('products'))
                                    <p class="text-red-400 text-xs p-4 bg-red-900/20">Please add at least one product.</p>
                                @endif
                            </div>

                            {{-- Notes --}}
                            <div class="mb-8">
                                <x-input-label for="notes" :value="__('Notes / Reference')"
                                    class="font-bold !text-gray-300" />
                                <textarea id="notes" name="notes"
                                    class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 shadow-sm"
                                    rows="2" placeholder="Optional notes...">{{ old('notes') }}</textarea>
                            </div>

                            {{-- Footer Buttons --}}
                            <div class="flex justify-end gap-4">
                                <button type="submit"
                                    class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-lg shadow-green-500/20 transition transform hover:-translate-y-0.5">
                                    Submit Transaction
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.productOptions = `
            @foreach($products as $product)
                <option value="{{ $product->id }}">
                    {{ $product->sku }} - {{ $product->name }} (Stock: {{ $product->stock_current }})
                </option>
            @endforeach
        `;
    </script>

    <script src="{{ asset('js/transaction.js') }}"></script>

</x-app-layout>