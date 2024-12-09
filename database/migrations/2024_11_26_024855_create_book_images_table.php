<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_images', function (Blueprint $table) {
            $table->char('id', 36)->primary(); // ID dạng UUID
            $table->char('book_id', 36); // Đảm bảo book_id cũng là UUID
            $table->string('image_path'); // Đường dẫn ảnh
            $table->text('description')->nullable(); // Mô tả (nếu cần)
            $table->timestamps();
            // Định nghĩa khóa ngoại
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_images');
    }
}
