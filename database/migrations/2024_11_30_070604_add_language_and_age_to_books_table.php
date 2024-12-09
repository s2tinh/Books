<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguageAndAgeToBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('language')->after('name')->nullable(); // Cột ngôn ngữ (nullable để cho phép giá trị null)
            $table->integer('age_group')->after('language')->nullable(); // Cột độ tuổi (nullable)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('language');
            $table->dropColumn('age_group');
        });
    }
}
