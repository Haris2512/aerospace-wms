<x-app-layout>
    <div class="min-h-screen bg-[#0B1120] text-gray-300 font-sans">
        
        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                
                {{-- HEADER --}}
                <div class="mb-8 flex justify-between items-center">
                    <div>
                        <h2 class="font-bold text-3xl text-white leading-tight">
                            {{ __('New Transaction') }}
                        </h2>
                        <p class="text-gray-400 text-sm mt-2">Record incoming or outgoing stock movements.</p>
                    </div>
                    <a href="{{ route('transactions.index') }}" class="px-4 py-2 bg-[#1F2937] border border-[#374151] rounded-lg text-gray-300 text-sm font-bold hover:text-white transition">
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
                                    <x-input-label for="type" :value="__('Transaction Type')" class="font-bold !text-gray-300" />
                                    <select id="type" name="type" class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5" onchange="toggleType()">
                                        <option value="incoming" {{ old('type') == 'incoming' ? 'selected' : '' }}>Incoming (Barang Masuk)</option>
                                        <option value="outgoing" {{ old('type') == 'outgoing' ? 'selected' : '' }}>Outgoing (Barang Keluar)</option>
                                    </select>
                                    @error('type') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- Tanggal --}}
                                <div>
                                    <x-input-label for="transaction_date" :value="__('Date')" class="font-bold !text-gray-300" />
                                    <input id="transaction_date" type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5" required />
                                    @error('transaction_date') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- Supplier (Muncul jika Incoming) --}}
                                <div id="supplier_field">
                                    <x-input-label for="supplier_id" :value="__('Supplier')" class="font-bold !text-gray-300" />
                                    <select id="supplier_id" name="supplier_id" class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5">
                                        <option value="">-- Select Supplier --</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- Customer (Muncul jika Outgoing) --}}
                                <div id="customer_field" class="hidden">
                                    <x-input-label for="customer_name" :value="__('Customer / Destination')" class="font-bold !text-gray-300" />
                                    <input id="customer_name" type="text" name="customer_name" value="{{ old('customer_name') }}" class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5" placeholder="e.g. Hangar B Maintenance Team" />
                                    @error('customer_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <hr class="border-[#2D3748] mb-8">

                            {{-- BAGIAN 2: DAFTAR PRODUK (DYNAMIC) --}}
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
                                        {{-- Baris Pertama (Default) --}}
                                        <tr id="row_0">
                                            <td class="px-4 py-3">
                                                <select name="products[0][id]" class="w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white text-sm focus:border-blue-500 focus:ring-blue-500" required>
                                                    <option value="">-- Select Component --</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}">
                                                            {{ $product->sku }} - {{ $product->name }} (Stock: {{ $product->stock_current }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="number" name="products[0][quantity]" class="w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white text-sm focus:border-blue-500 focus:ring-blue-500" min="1" value="1" required>
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <button type="button" onclick="removeRow(0)" class="text-red-500 hover:text-red-400">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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
                                <x-input-label for="notes" :value="__('Notes / Reference')" class="font-bold !text-gray-300" />
                                <textarea id="notes" name="notes" class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 shadow-sm" rows="2" placeholder="Optional notes...">{{ old('notes') }}</textarea>
                            </div>

                            {{-- Footer Buttons --}}
                            <div class="flex justify-end gap-4">
                                <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-lg shadow-green-500/20 transition transform hover:-translate-y-0.5">
                                    Submit Transaction
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT SEDERHANA UNTUK FITUR DINAMIS --}}
    <script>
        // 1. Toggle Tipe Transaksi (Masuk/Keluar)
        function toggleType() {
            const type = document.getElementById('type').value;
            const supplierField = document.getElementById('supplier_field');
            const customerField = document.getElementById('customer_field');

            if (type === 'incoming') {
                supplierField.classList.remove('hidden');
                customerField.classList.add('hidden');
            } else {
                supplierField.classList.add('hidden');
                customerField.classList.remove('hidden');
            }
        }

        // 2. Tambah Baris Produk
        let rowCount = 1;
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

        // 3. Hapus Baris Produk
        function removeRow(rowId) {
            const row = document.getElementById('row_' + rowId);
            if (document.querySelectorAll('#product_rows tr').length > 1) {
                row.remove();
            } else {
                alert("At least one item is required.");
            }
        }

        // Jalankan saat loading awal
        document.addEventListener('DOMContentLoaded', function() {
            toggleType();
        });
    </script>
</x-app-layout>