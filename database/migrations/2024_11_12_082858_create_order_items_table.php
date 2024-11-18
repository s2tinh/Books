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
        Schema::create('order_items', function (Blueprint $table) {
            $table->char('id',36)->primary();
            $table->char('order_id',36);
            $table->char('book_id',36);
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');  // Hoặc 'set null',
            $table->foreign('book_id')->references('id')->on('books');  // Hoặc 'set null',
            $table->integer('quantity');
            $table->decimal('price',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
