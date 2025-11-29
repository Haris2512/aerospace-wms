/**
 * File: public/js/transaction.js
 * Menangani logika form transaksi dinamis
 */

// 1. Toggle Tipe Transaksi
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
function addProductRow() {
    const container = document.getElementById('product_rows');
    // Hitung jumlah baris saat ini untuk index array yang unik
    const rowCount = container.children.length; 
    
    // Kita ambil HTML Option dari variabel global 'window.productOptions'
    // yang dikirim dari Blade
    const newRow = `
        <tr id="row_${rowCount}">
            <td class="px-4 py-3">
                <select name="products[${rowCount}][id]" class="w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white text-sm focus:border-blue-500 focus:ring-blue-500" required>
                    <option value="">-- Select Component --</option>
                    ${window.productOptions} 
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

// Jalankan saat loading
document.addEventListener('DOMContentLoaded', function() {
    toggleType();
});