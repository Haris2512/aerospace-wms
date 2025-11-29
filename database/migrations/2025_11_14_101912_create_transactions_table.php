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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            //kolom dario pdf
            $table->string('transaction_number')->unique();
            $table->enum('type', ['incoming','outgoing']);
            $table->date("transaction_date");
            $table->string('status');
            $table->text('notes')->nullable();

            //kolom untuk barng masuk
            $table->foreignId("supplier_id")->nullable()->constrained("users")->onDelete('set null');

            //kolom untuk barng kluar
            $table->string("customer_name")->nullable();

            //kolom untuk yang catat dan approve
            $table->foreignId("created_by_user_id")->nullable()->constrained("users")->onDelete('set null');
            $table->foreignId("approved_by_user_id")->nullable()->constrained("users")->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
