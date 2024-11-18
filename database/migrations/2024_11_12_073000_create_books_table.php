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
        Schema::create('books', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('title');
            $table->string('author');
            $table->decimal('price', 10, 2);
            $table->text('description');
            $table->date('publication_date');
            $table->char('category_id', 36);
            $table->string('images', 100);
            $table->string('cover_type')->nullable(); // Loại bìa
            $table->string('book_size')->nullable();  // Khổ sách
            $table->string('publisher')->nullable();  // Nhà xuất bản
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
