<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('restock_orders', function (Blueprint $table) {
            $table->id();

            // Kolom dari PDF 
            $table->string('po_number')->unique(); // Nomor PO (Purchase Order)
            $table->date('order_date'); // Tanggal order
            $table->date('expected_delivery_date')->nullable(); // Estimasi tgl kirim
            $table->string('status'); // (Pending, Confirmed, In Transit, Received)
            $table->text('notes')->nullable(); // Catatan

            // Relasi ke Supplier (User)
            $table->foreignId('supplier_id')->nullable()
                ->constrained('users') // Merujuk ke tabel users (role supplier)
                ->onDelete('set null');

            // Relasi ke Manager (User) yang membuat pesanan
            $table->foreignId('created_by_user_id')->nullable() // Manager yg buat
                ->constrained('users')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restock_orders');
    }
};