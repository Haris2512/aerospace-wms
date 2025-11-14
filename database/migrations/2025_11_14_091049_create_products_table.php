<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // kolom dari pdf 
            $table->string('name');
            $table->string('sku')->unique();
            $table->text('description');
            
            //relasi ke kategori
            $table->foreignId('category_id')->nullable()->constrained("categories")->onDelete('set null');

            //kolom harga
            $table->decimal('purchase_price', 15, 2)->default(0);
            $table->decimal('sale_price', 15, 2)->default(0);

            //kolom stok
            $table->integer("stock_current")->default(0);
            $table->integer("stock_minimum")->default(0);

            //kolom info lain
            $table->string("unit");
            $table->string("storage_location")->nullable();
            $table->string("image_path");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
