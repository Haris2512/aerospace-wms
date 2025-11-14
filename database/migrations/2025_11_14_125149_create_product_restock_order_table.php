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
        // Nama tabel pivot: product_restock_order
        Schema::create('product_restock_order', function (Blueprint $table) {

            // Kunci 1: Merujuk ke tabel 'restock_orders'
            $table->foreignId('restock_order_id')
                ->constrained('restock_orders')
                ->cascadeOnDelete(); // Jika PO dihapus, detail ini hilang

            // Kunci 2: Merujuk ke tabel 'products'
            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete(); // Jika produk dihapus, detail ini hilang

            // Kolom data utamanya
            $table->integer('quantity'); // Jumlah yang dipesan

            // Kunci Primary Gabungan
            $table->primary(['restock_order_id', 'product_id'], 'product_restock_order_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_restock_order');
    }
};