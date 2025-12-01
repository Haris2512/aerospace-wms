<x-app-layout>
    <div class="min-h-screen bg-[#0B1120] text-gray-300 font-sans">
        
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                

                {{-- HEADER --}}
                <div class="mb-8 flex justify-between items-center">
                    <div>
                        <h2 class="font-bold text-3xl text-white leading-tight">
                            Edit Transaction: <span class="font-mono text-blue-400">{{ $transaction->transaction_number }}</span>
                        </h2>
                        <p class="text-gray-400 text-sm mt-2">Update items or notes. Core transaction details are locked.</p>
                    </div>
                </div>

                <div class="bg-[#151B2D] shadow-2xl sm:rounded-2xl overflow-hidden border border-[#2D3748]">
                    <div class="p-8">
                        
                        <form method="POST" action="{{ route('transactions.update', $transaction) }}">
                            @csrf
                            @method('PUT')

                            {{-- BAGIAN 1: INFO TRANSAKSI (LOCKED / READ-ONLY) --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 p-6 bg-[#1A202C] rounded-xl border border-[#2D3748]">
                                
                                {{-- Tipe Transaksi (Locked) --}}
                                <div>
                                    <x-input-label :value="__('Transaction Type')" class="font-bold !text-gray-500" />
                                    
                                    <div class="mt-2 p-2.5 rounded-lg border border-[#2D3748] bg-[#0B1120] text-gray-300 font-bold flex items-center cursor-not-allowed">
                                        @if($transaction->type == 'incoming')
                                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                            Incoming (Barang Masuk)
                                        @else
                                            <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                            Outgoing (Barang Keluar)
                                        @endif
                                    </div>

                                    <input type="hidden" name="type" id="type" value="{{ $transaction->type }}">
                                </div>

                                {{-- Tanggal (Locked) --}}
                                <div>
                                    <x-input-label :value="__('Transaction Date')" class="font-bold !text-gray-500" />
                                    <input type="date" name="transaction_date" value="{{ $transaction->transaction_date }}" class="block mt-2 w-full rounded-lg border-[#2D3748] bg-[#0B1120] text-gray-400 cursor-not-allowed font-bold" readonly />
                                </div>

                                {{-- Supplier / Customer (Locked) --}}
                                <div id="supplier_field" class="{{ $transaction->type == 'incoming' ? '' : 'hidden' }}">
                                    <x-input-label :value="__('Supplier')" class="font-bold !text-gray-500" />
                                    <input type="text" value="{{ $transaction->supplier->name ?? '-' }}" class="block mt-2 w-full rounded-lg border-[#2D3748] bg-[#0B1120] text-gray-400 cursor-not-allowed font-bold" readonly />
                                    <input type="hidden" name="supplier_id" value="{{ $transaction->supplier_id }}">
                                </div>

                                <div id="customer_field" class="{{ $transaction->type == 'outgoing' ? '' : 'hidden' }}">
                                    <x-input-label :value="__('Customer / Destination')" class="font-bold !text-gray-500" />
                                    <input type="text" name="customer_name" value="{{ $transaction->customer_name }}" class="block mt-2 w-full rounded-lg border-[#2D3748] bg-[#0B1120] text-gray-400 cursor-not-allowed font-bold" readonly />
                                </div>

                                <div class="flex items-center col-span-1 md:col-span-2">
                                    <p class="text-xs text-yellow-500 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        Core details are locked. Only items & notes are editable.
                                    </p>
                                </div>
                            </div>

                            <hr class="border-[#2D3748] mb-8">

                            {{-- BAGIAN 2: DAFTAR BARANG (EDITABLE) --}}
                            <div class="mb-4 flex justify-between items-center">
                                <h3 class="text-lg font-bold text-white">Edit Items List</h3>
                                <button type="button" onclick="addProductRow()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-lg transition">
                                    + Add Item
                                </button>
                            </div>

                            <div class="bg-[#1A202C] rounded-xl border border-[#2D3748] overflow-hidden mb-6">
                                <table class="min-w-full divide-y divide-[#2D3748]">
                                    <thead class="bg-[#0B1120]">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-400 uppercase">Product</th>
                                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-400 uppercase w-32">Quantity</th>
                                            <th class="px-4 py-3 text-right text-xs font-bold text-gray-400 uppercase w-20">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="product_rows" class="divide-y divide-[#2D3748]">
                                        @foreach($transaction->products as $index => $item)
                                            <tr id="row_{{ $index }}">
                                                <td class="px-4 py-3">
                                                    <select name="products[{{ $index }}][id]" class="w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white text-sm focus:border-blue-500 focus:ring-blue-500" required>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" {{ $item->id == $product->id ? 'selected' : '' }}>
                                                                {{ $product->sku }} - {{ $product->name }} (Stock: {{ $product->stock_current }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <input type="number" name="products[{{ $index }}][quantity]" class="w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white text-sm focus:border-blue-500 focus:ring-blue-500" min="1" value="{{ $item->pivot->quantity }}" required>
                                                </td>
                                                <td class="px-4 py-3 text-right">
                                                    <button type="button" onclick="removeRow({{ $index }})" class="text-red-500 hover:text-red-400">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- NOTES --}}
                            <div class="mb-8">
                                <x-input-label for="notes" :value="__('Notes / Reference')" class="font-bold !text-gray-300" />
                                <textarea id="notes" name="notes" class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 shadow-sm" rows="2">{{ old('notes', $transaction->notes) }}</textarea>
                            </div>

                            {{-- TOMBOL AKSI (UPDATED) --}}
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('transactions.index') }}" class="px-6 py-3 bg-[#1F2937] hover:bg-[#374151] text-gray-300 font-bold rounded-lg border border-[#4A5568] transition">Cancel</a>
                                <button type="submit" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg shadow-lg transition transform hover:-translate-y-0.5">
                                    Update Changes
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT --}}
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