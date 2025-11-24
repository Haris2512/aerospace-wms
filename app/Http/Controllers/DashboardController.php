<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\RestockOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [];

        // --- LOGIKA KHUSUS ADMIN & MANAGER ---
        if ($user->role === 'admin' || $user->role === 'manager') {
            $data['total_products'] = Product::count();
            $data['total_value'] = Product::sum(DB::raw('purchase_price * stock_current'));
            $data['low_stock_count'] = Product::whereColumn('stock_current', '<=', 'stock_minimum')->count();
            $data['pending_transactions'] = Transaction::where('status', 'pending')->count();

            // Ambil 5 produk dengan stok menipis untuk ditampilkan di dashboard
            $data['low_stock_items'] = Product::whereColumn('stock_current', '<=', 'stock_minimum')
                ->orderBy('stock_current', 'asc')
                ->take(5)
                ->get();
        }

        // --- LOGIKA KHUSUS STAFF ---
        if ($user->role === 'staff') {
            $data['transactions_today'] = Transaction::where('created_by_user_id', $user->id)
                ->whereDate('created_at', today())
                ->count();
            $data['pending_transactions'] = Transaction::where('created_by_user_id', $user->id)
                ->where('status', 'pending')
                ->count();
            $data['recent_transactions'] = Transaction::where('created_by_user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();
        }

        // --- LOGIKA KHUSUS SUPPLIER ---
        if ($user->role === 'supplier') {
            $data['pending_po'] = RestockOrder::where('supplier_id', $user->id)
                ->where('status', 'pending')
                ->count();
            $data['completed_po'] = RestockOrder::where('supplier_id', $user->id)
                ->where('status', 'received')
                ->count();
            $data['incoming_orders'] = RestockOrder::where('supplier_id', $user->id)
                ->where('status', 'pending')
                ->with('products')
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboard', compact('data'));
    }
}