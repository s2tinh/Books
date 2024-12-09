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
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->char('id', 36)->primary(); // Đảm bảo phương thức primary() được gọi đúng
            $table->string('code')->unique()->after('id'); // Thêm cột 'code' (đảm bảo mã loại là duy nhất);s
            $table->string('name'); // Cột để lưu tên của danh mục con
            $table->char('category_id', 36); // Khóa ngoại để liên kết với bảng categories
            $table->timestamps();
            // Định nghĩa khóa ngoại liên kết với bảng categories
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categories');
    }
};
