<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\RestockOrder;
use App\Services\RestockOrderService;
use App\Http\Requests\StoreRestockOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class RestockOrderController extends Controller
{
    protected $restockService;

    public function __construct(RestockOrderService $restockService)
    {
        $this->restockService = $restockService;
    }
    public function index()
    {$orders = $this->restockService->getOrdersByUser(Auth::user());
        
        return view('restock.index', compact('orders'));
    }

    public function create()
    {
        $suppliers = User::where('role', 'supplier')
            ->where('status', 'approved')
            ->orderBy('name')
            ->get();

        $products = Product::orderBy('name')->get();

        return view('restock.create', compact('suppliers', 'products'));
    }

    public function store(StoreRestockOrderRequest $request)
    {
        $validated = $request->validated();
        $validated['po_number'] = 'PO-AERO-' . strtoupper(Str::random(8));

        try {
            $this->restockService->createOrder($validated);

            return redirect()->route('restock.index')
                ->with('success', 'Purchase Order (PO) berhasil dibuat dan dikirim ke Supplier.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat PO: ' . $e->getMessage())->withInput();
        }
    }

    public function show(RestockOrder $restock)     {
        $restock->load(['products', 'supplier', 'creator']);

        return view('restock.show', ['restockOrder' => $restock]);
    }
    public function confirm(RestockOrder $restockOrder)
    {
        if (auth()->user()->id !== $restockOrder->supplier_id) {
            abort(403, 'Unauthorized action.');
        }

        $this->restockService->updateStatus($restockOrder, 'confirmed');

        return back()->with('success', 'Purchase Order has been confirmed successfully.');
    }
    
    public function updateStatus(Request $request, RestockOrder $restockOrder)
    {
        $request->validate([
            'status' => 'required|in:shipped,received' 
        ]);

        $this->restockService->updateStatus($restockOrder, $request->status);

        return back()->with('success', 'Order status updated successfully.');
    }
    public function reject(RestockOrder $restockOrder)
    {
        if (auth()->user()->id !== $restockOrder->supplier_id) {
            abort(403, 'Unauthorized action.');
        }

        $this->restockService->updateStatus($restockOrder, 'rejected');

        return back()->with('error', 'Purchase Order has been rejected.');
    }

}