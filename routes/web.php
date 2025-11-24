<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RestockOrderController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard 
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// --- GRUP UTAMA (Harus Login) ---
Route::middleware('auth')->group(function () {

    // Profile (Semua User)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- 1. Master Data (Hanya ADMIN & MANAGER) ---
    Route::middleware('role:admin,manager')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
    });

    // --- 2. Transaksi Harian (ADMIN, MANAGER, STAFF) ---
    // Supplier TIDAK boleh masuk sini
    Route::middleware('role:admin,manager,staff')->group(function () {
        Route::resource('transactions', TransactionController::class);
    });

    // --- 3. Tugas Khusus Manager (Hanya MANAGER) ---
    Route::middleware('role:manager')->group(function () {
        // Kelola Restock PO
        Route::resource('restock', RestockOrderController::class);

        // Approve Transaksi (Rute Custom)
        Route::post('/transactions/{transaction}/approve', [TransactionController::class, 'approve'])
            ->name('transactions.approve');
    });

});

require __DIR__ . '/auth.php';