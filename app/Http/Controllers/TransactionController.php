<?php

namespace App\HttpControllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\StoreTransactionRequest; // 1. IMPORT Form Request 'Si Tukang Validasi'

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Menampilkan halaman daftar transaksi (Read).
     */
    public function index()
    {
        $transactions = Transaction::with(['creator', 'approver', 'supplier'])
                                    ->latest()
                                    ->paginate(15);
                                    
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Menampilkan form tambah transaksi (Create).
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();
        $suppliers = User::where('role', 'supplier')->where('status', 'approved')->orderBy('name')->get();
        
        return view('transactions.create', compact('products', 'suppliers'));
    }

    /**
     * Menyimpan data transaksi baru (Create)
     */
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

    /**
     * Menampilkan detail satu transaksi (Read).
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['products', 'supplier', 'creator', 'approver']);
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Menampilkan form edit transaksi.
     */
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

    /**
     * Memperbarui data transaksi yang ada (Update).
     */
    public function update(Request $request, Transaction $transaction)
    {
        
        return redirect()->route('transactions.index')
                        ->with('info', 'Fitur update belum diimplementasikan.');
    }

    
    /**
     * Menghapus data transaksi (Delete).
     */
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
    
    /**
     * Menyetujui transaksi (Approve) oleh Manager.
     * Ini adalah method custom.
     */
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