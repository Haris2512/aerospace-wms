<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use illuminate\Http\Request;

class TransactionService
{
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

            foreach ($data['products'] as $item) {
                $product = Product::find($item['id']);
                $quantity = $item['quantity'];

                if ($transaction->type === 'outgoing') {
                    if ($quantity > $product->stock_current) {
                        throw new \Exception(
                            "Stok tidak cukup untuk '{$product->name}'. Tersedia: {$product->stock_current}, Diminta: {$quantity}."
                        );
                    }
                }

                $pivotData[$item['id']] = ['quantity' => $quantity];
            }

            $transaction->products()->attach($pivotData);

            return $transaction;
        });
    }
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
    public function getTransactionsWithFilters(Request $request)
    {
        $query = Transaction::with(['creator', 'approver', 'supplier'])
            ->withCount('products');

        if ($request->has('type') && in_array($request->type, ['incoming', 'outgoing'])) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where('transaction_number', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('transaction_date', $request->date);
        }

        $query->latest(); 

        return $query->paginate(15)->withQueryString();
    }

    public function updateTransaction(Transaction $transaction, array $data): Transaction
    {
        if ($transaction->status !== 'pending') {
            throw new \Exception('Hanya transaksi dengan status Pending yang dapat diedit.');
        }

        return DB::transaction(function () use ($transaction, $data) {

            $pivotData = [];

            foreach ($data['products'] as $item) {
                $product = Product::find($item['id']);
                $quantity = $item['quantity'];

                if ($transaction->type === 'outgoing') {
                    if ($quantity > $product->stock_current) {
                        throw new \Exception(
                            "Stok tidak cukup untuk '{$product->name}'. Tersedia: {$product->stock_current}, Diminta: {$quantity}."
                        );
                    }
                }

                $pivotData[$item['id']] = ['quantity' => $quantity];
            }

            $transaction->update([
                'transaction_date' => $data['transaction_date'],
                'notes' => $data['notes'] ?? null,
                'supplier_id' => $data['supplier_id'] ?? $transaction->supplier_id,
                'customer_name' => $data['customer_name'] ?? $transaction->customer_name,
            ]);

            $transaction->products()->sync($pivotData);

            return $transaction;
        });
    }
}