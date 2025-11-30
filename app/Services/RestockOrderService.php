<?php

namespace App\Services;

use App\Models\RestockOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class RestockOrderService
{

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

    public function updateStatus(RestockOrder $order, string $status): void
    {
        $order->update([
            'status' => $status
        ]);

    }
}