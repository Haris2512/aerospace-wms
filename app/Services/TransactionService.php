<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/**
 * Service class untuk menangani logika bisnis Transaksi (Barang Masuk/Keluar).
 */
class TransactionService
{
    /**
     * Menyimpan transaksi baru (status 'pending') oleh Staff Gudang.
     *
     * @param array $data Data dari $request->validate()
     * @return Transaction Model Transaksi yang baru dibuat
     */
    public function storeTransaction(array $data): Transaction
    {
        return DB::transaction(function () use ($data) {
            
            $transaction = Transaction::create([
                'transaction_number' => $data['transaction_number'],
                'type' => $data['type'],
                'transaction_date' => $data['transaction_date'],
                'status' => 'pending',
                'notes' => $data['notes'] ?? null,
                'supplier_id' => $data['supplier_id'] ?? null,
                'customer_name' => $data['customer_name'] ?? null,
                'created_by_user_id' => Auth::id(),
            ]);

            $pivotData = [];
            foreach ($data['products'] as $product) {
                $pivotData[$product['id']] = ['quantity' => $product['quantity']];
            }

            $transaction->products()->attach($pivotData);

            return $transaction;
        });
    }

    /**
     * Menyetujui transaksi (approve) oleh Warehouse Manager.
     *
     * @param Transaction $transaction Transaksi yang akan disetujui
     * @return void
     * @throws \Exception Jika validasi gagal (misal: stok tidak cukup)
     */
    public function approveTransaction(Transaction $transaction): void
    {
        if ($transaction->status !== 'pending') {
            throw new \Exception('Transaksi ini sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($transaction) {
            
            $productsInTransaction = $transaction->products;

            foreach ($productsInTransaction as $product) {
                $quantity = $product->pivot->quantity;

                if ($transaction->type === 'outgoing') {
                    if ($product->stock_current < $quantity) {
                        throw new \Exception("Stok tidak cukup untuk produk '{$product->name}'. Stok saat ini: {$product->stock_current}, Dibutuhkan: {$quantity}");
                    }
                    $product->decrement('stock_current', $quantity);
                
                } elseif ($transaction->type === 'incoming') {
                    $product->increment('stock_current', $quantity);
                }
            }

            $transaction->update([
                'status' => 'approved',
                'approved_by_user_id' => Auth::id(),
            ]);
        });
    }
}