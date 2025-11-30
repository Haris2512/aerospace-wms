<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RestockOrderController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile (Semua User)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- (Hanya ADMIN & MANAGER) ---
    Route::middleware('role:admin,manager')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::get('/products/{product}/print-qr', [ProductController::class, 'printQr'])->name('products.print-qr');
    });

    // --- (ADMIN, MANAGER, STAFF) ---
    Route::middleware('role:admin,manager,staff')->group(function () {
        Route::resource('transactions', TransactionController::class);
    });

    // --- RESTOCK MANAGEMENT (Manager & Supplier) ---
    Route::middleware('role:manager,supplier,admin')->group(function () {
        Route::resource('restock', RestockOrderController::class);

        Route::patch('/restock/{restockOrder}/confirm', [RestockOrderController::class, 'confirm'])->name("restock.confirm");
        Route::patch('/restock/{restockOrder}/reject', [RestockOrderController::class, 'reject'])->name('restock.reject');
    });
    // USER MANAGEMENT (KHUSUS ADMIN) ---
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
    });

    // --- (Hanya Manager) ---
    Route::middleware('role:manager')->group(function () {
        Route::post('/transactions/{transaction}/approve', [TransactionController::class, 'approve'])
            ->name('transactions.approve');
        Route::patch('/restock/{restockOrder}/update-status', [RestockOrderController::class, 'updateStatus'])
            ->name('restock.update-status');
    });

});

require __DIR__ . '/auth.php';