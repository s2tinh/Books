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
        Schema::create('customers', function (Blueprint $table) {
            $table->char('id', 36)->primary(); // Tạo cột 'id' với kiểu dữ liệu CHARACTER(36) và đánh dấu là khóa chính
            $table->string('name'); // Tạo cột 'name' với kiểu dữ liệu VARCHAR(255)
            $table->string('email')->unique(); // Tạo cột 'email' với kiểu dữ liệu VARCHAR(255) và đánh dấu là unique
            $table->string('phone', 20); // Tạo cột 'phone' với kiểu dữ liệu VARCHAR(20)
            $table->text('address'); // Tạo cột 'address' với kiểu dữ liệu TEXT
            $table->timestamps(); // Tạo cột 'created_at' và 'updated_at' với kiểu dữ liệu TIMESTAMP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
