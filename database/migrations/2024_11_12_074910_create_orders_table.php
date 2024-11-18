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
        Schema::create('orders', function (Blueprint $table) {
            $table->char('id',36)->primary();
            $table->char('customer_id',36);
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');  // Hoặc 'set null', 'restrict', 'no action'
            $table->enum('status',['pending','completed','cancelled']);
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
