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
        Schema::create('payments', function (Blueprint $table) {
            $table->char('id',36)->primary();
            $table->char('order_id',36);
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->timestamp ('payment_date');
            $table->decimal('amount',10,2);
            $table->enum('method',['cash','card','online']);
            $table->enum('status',['paid','unpaid','refunded']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
