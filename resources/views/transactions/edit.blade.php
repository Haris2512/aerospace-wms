<x-app-layout>
    <div class="min-h-screen bg-[#0B1120] text-gray-300 font-sans">
        
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                
                <div class="mb-8 flex justify-between items-center">
                    <div>
                        <h2 class="font-bold text-3xl text-white leading-tight">
                            Edit Transaction: <span class="font-mono text-blue-400">{{ $transaction->transaction_number }}</span>
                        </h2>
                        <p class="text-gray-400 text-sm mt-2">Update details. Only pending transactions can be edited.</p>
                    </div>
                </div>

                <div class="bg-[#151B2D] shadow-2xl sm:rounded-2xl overflow-hidden border border-[#2D3748]">
                    <div class="p-8">
                        
                        {{-- FORM EDIT --}}
                        {{-- Perhatikan action mengarah ke 'update' dan ada method PUT --}}
                        <form method="POST" action="{{ route('transactions.update', $transaction) }}">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                                
                                {{-- Tipe (Read Only agar tidak merusak logika) --}}
                                <div>
                                    <x-input-label for="type" :value="__('Transaction Type')" class="font-bold !text-gray-300" />
                                    <input type="text" value="{{ ucfirst($transaction->type) }}" class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#1A202C] text-gray-400 cursor-not-allowed" readonly />
                                    {{-- Kita kirim hidden input tipe aslinya --}}
                                    <input type="hidden" name="type" id="type" value="{{ $transaction->type }}">
                                </div>

                                {{-- Tanggal --}}
                                <div>
                                    <x-input-label for="transaction_date" :value="__('Date')" class="font-bold !text-gray-300" />
                                    <input id="transaction_date" type="date" name="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date) }}" class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5" required />
                                    @error('transaction_date') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- Supplier / Customer (Sesuai Tipe) --}}
                                @if($transaction->type == 'incoming')
                                    <div id="supplier_field">
                                        <x-input-label for="supplier_id" :value="__('Supplier')" class="font-bold !text-gray-300" />
                                        <select id="supplier_id" name="supplier_id" class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5">
                                            <option value="">-- Select Supplier --</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}" {{ old('supplier_id', $transaction->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                @else
                                    <div id="customer_field">
                                        <x-input-label for="customer_name" :value="__('Customer / Destination')" class="font-bold !text-gray-300" />
                                        <input id="customer_name" type="text" name="customer_name" value="{{ old('customer_name', $transaction->customer_name) }}" class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5" />
                                        @error('customer_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                @endif
                            </div>

                            <hr class="border-[#2D3748] mb-8">

                            {{-- DAFTAR PRODUK (DYNAMIC) --}}
                            <div class="mb-4 flex justify-between items-center">
                                <h3 class="text-lg font-bold text-white">Items List</h3>
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
                                        {{-- LOOP DATA LAMA DARI DATABASE --}}
                                        @foreach($transaction->products as $index => $item)
                                            <tr id="row_{{ $index }}">
                                                <td class="px-4 py-3">
                                                    <select name="products[{{ $index }}][id]" class="w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white text-sm focus:border-blue-500 focus:ring-blue-500" required>
                                                        <option value="">-- Select Component --</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" {{ $item->id == $product->id ? 'selected' : '' }}>
                                                                {{ $product->sku }} - {{ $product->name }} (Stock: {{ $product->stock_current }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="px-4 py-3">
                                                    {{-- Perhatikan cara ambil quantity dari pivot --}}
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

                            {{-- Notes --}}
                            <div class="mb-8">
                                <x-input-label for="notes" :value="__('Notes / Reference')" class="font-bold !text-gray-300" />
                                <textarea id="notes" name="notes" class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 shadow-sm" rows="2">{{ old('notes', $transaction->notes) }}</textarea>
                            </div>

                            <div class="flex justify-end gap-4">
                                <a href="{{ route('transactions.index') }}" class="px-6 py-3 bg-[#1F2937] hover:bg-[#374151] text-gray-300 font-bold rounded-lg border border-[#4A5568] transition">Cancel</a>
                                <button type="submit" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg shadow-lg transition transform hover:-translate-y-0.5">
                                    Update Transaction
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT (Diadaptasi untuk Edit) --}}
    <script>
        // Kita mulai rowCount dari jumlah item yang sudah ada agar ID-nya unik
        let rowCount = {{ count($transaction->products) }};

        function addProductRow() {
            const container = document.getElementById('product_rows');
            const newRow = `
                <tr id="row_${rowCount}">
                    <td class="px-4 py-3">
                        <select name="products[${rowCount}][id]" class="w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white text-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">-- Select Component --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->sku }} - {{ $product->name }} (Stock: {{ $product->stock_current }})</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-4 py-3">
                        <input type="number" name="products[${rowCount}][quantity]" class="w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white text-sm focus:border-blue-500 focus:ring-blue-500" min="1" value="1" required>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <button type="button" onclick="removeRow(${rowCount})" class="text-red-500 hover:text-red-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </td>
                </tr>
            `;
            container.insertAdjacentHTML('beforeend', newRow);
            rowCount++;
        }

        function removeRow(rowId) {
            const row = document.getElementById('row_' + rowId);
            if (document.querySelectorAll('#product_rows tr').length > 1) {
                row.remove();
            } else {
                alert("At least one item is required.");
            }
        }
    </script>
</x-app-layout>