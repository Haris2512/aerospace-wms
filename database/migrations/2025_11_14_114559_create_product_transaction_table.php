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
        Schema::create('product_transaction', function (Blueprint $table) {

            $table->foreignId('transaction_id')->constrained("transactions")->cascadeOnDelete();//jka trsk di hpus, detail hilang
            $table->foreignId('product_id')->constrained("products")->cascadeOnDelete();//jka prdk di hpus, detail hilang
            $table->integer("quantity");    
            $table->primary(["transaction_id", "product_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_transaction');
    }
};
