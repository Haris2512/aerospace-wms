<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }
    public function index(Request $request)
    {
        $transactions = $this->transactionService->getTransactionsWithFilters($request);
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        $suppliers = User::where('role', 'supplier')->where('status', 'approved')->orderBy('name')->get();

        return view('transactions.create', compact('products', 'suppliers'));
    }

    public function store(StoreTransactionRequest $request)
    {
        $validated = $request->validated();
        $validated['transaction_number'] = 'TRX-' . strtoupper(Str::random(10));

        try {
            $this->transactionService->storeTransaction($validated);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mencatat transaksi: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dicatat & menunggu persetujuan.');
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['products', 'supplier', 'creator', 'approver']);
        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return redirect()->route('transactions.index')
                ->with('error', 'Hanya transaksi (Pending) yang dapat diedit.');
        }

        $products = Product::orderBy('name')->get();
        $suppliers = User::where('role', 'supplier')->where('status', 'approved')->orderBy('name')->get();
        $transaction->load('products');

        return view('transactions.edit', compact('transaction', 'products', 'suppliers'));
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $validated = $request->validated();

        try {
            $this->transactionService->updateTransaction($transaction, $validated);

            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update transaksi: ' . $e->getMessage())->withInput();
        }
    }
    public function destroy(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return redirect()->route('transactions.index')
                ->with('error', 'Hanya transaksi (Pending) yang dapat dihapus.');
        }

        $transaction->products()->detach();
        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi (Pending) berhasil dihapus.');
    }
    public function approve(Transaction $transaction)
    {
        try {
            $this->transactionService->approveTransaction($transaction);

            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi ' . $transaction->transaction_number . ' berhasil disetujui. Stok telah diupdate.');

        } catch (\Exception $e) {
            return redirect()->route('transactions.index')
                ->with('error', $e->getMessage());
        }
    }
}