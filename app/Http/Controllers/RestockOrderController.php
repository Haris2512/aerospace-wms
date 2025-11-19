<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\RestockOrder;
use App\Services\RestockOrderService;
use App\Http\Requests\StoreRestockOrderRequest; 
use Illuminate\Http\Request;
use Illuminate\Support\Str; 

class RestockOrderController extends Controller
{
    protected $restockService;

    public function __construct(RestockOrderService $restockService)
    {
        $this->restockService = $restockService;
    }

    /**
     * Menampilkan daftar pesanan restock (PO).
     */
    public function index()
    {
        // Ambil data PO beserta relasi Supplier dan Manager pembuatnya
        $orders = RestockOrder::with(['supplier', 'creator'])
            ->latest()
            ->paginate(10);

        return view('restock.index', compact('orders'));
    }

    /**
     * Menampilkan form pembuatan PO baru.
     */
    public function create()
    {
        // 1. Ambil Supplier yang valid (Role supplier & Status approved)
        $suppliers = User::where('role', 'supplier')
            ->where('status', 'approved')
            ->orderBy('name')
            ->get();

        // 2. Ambil daftar produk untuk dipilih
        $products = Product::orderBy('name')->get();

        return view('restock.create', compact('suppliers', 'products'));
    }

    /**
     * Menyimpan PO baru (Pekerjaan Berat diserahkan ke Service).
     */
    public function store(StoreRestockOrderRequest $request)
    {
        // 1. Ambil data yang sudah divalidasi otomatis
        $validated = $request->validated();

        // 2. Generate Nomor PO Unik (Format: PO-AERO-[ACAK])
        $validated['po_number'] = 'PO-AERO-' . strtoupper(Str::random(8));

        try {
            // 3. Panggil Service untuk simpan ke DB
            $this->restockService->createOrder($validated);

            return redirect()->route('restock.index')
                ->with('success', 'Purchase Order (PO) berhasil dibuat dan dikirim ke Supplier.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat PO: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan detail satu PO.
     */
    public function show(RestockOrder $restockOrder)
    {
        $restockOrder->load(['products', 'supplier', 'creator']);

        return view('restock.show', compact('restockOrder'));
    }

}