<?php

namespace App\Services;

use App\Models\RestockOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/**
 * Service class untuk menangani logika bisnis Restock (Pemesanan ke Supplier).
 */
class RestockOrderService
{
    /**
     * Manager membuat pesanan restock baru ke Supplier.
     *
     * @param array $data Data yang sudah divalidasi
     * @return RestockOrder Model RestockOrder yang baru dibuat
     */
    public function createOrder(array $data): RestockOrder
    {
        return DB::transaction(function () use ($data) {
            
            // 1. Buat Kepala PO (Purchase Order)
            $order = RestockOrder::create([
                'po_number' => $data['po_number'], // Digenerate di controller
                'order_date' => $data['order_date'],
                'expected_delivery_date' => $data['expected_delivery_date'] ?? null,
                'status' => 'pending', // Status awal: Menunggu Konfirmasi Supplier
                'notes' => $data['notes'] ?? null,
                'supplier_id' => $data['supplier_id'],
                'created_by_user_id' => Auth::id(), // Manager yang buat
            ]);

            // 2. Siapkan data Pivot (Isi PO)
            $pivotData = [];
            foreach ($data['products'] as $product) {
                // Format: [product_id => ['quantity' => 10]]
                $pivotData[$product['id']] = ['quantity' => $product['quantity']];
            }

            // 3. Simpan ke tabel pivot (product_restock_order)
            $order->products()->attach($pivotData);

            return $order;
        });
    }

    /**
     * Mengupdate status pesanan (misal: Supplier mengonfirmasi).
     *
     * @param RestockOrder $order
     * @param string $status (confirmed, shipped, received, rejected)
     */
    public function updateStatus(RestockOrder $order, string $status): void
    {
        // Update status di database
        $order->update([
            'status' => $status
        ]);

        // Catatan: Sesuai PDF, jika status 'received', 
        // stok TIDAK otomatis bertambah di sini.
        // Staff gudang harus membuat 'Incoming Transaction' terpisah untuk verifikasi fisik.
    }
}