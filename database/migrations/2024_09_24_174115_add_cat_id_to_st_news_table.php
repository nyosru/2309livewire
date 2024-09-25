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
        Schema::table('st_news', function (Blueprint $table) {
            $table->unsignedBigInteger('cat_id')->nullable()->after('id'); // Добавляем поле cat_id
            $table->foreign('cat_id')->references('id')->on('st_news_parsing_category')->onDelete('set null'); // Устанавливаем внешний ключ на таблицу st_news_parsing_category
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('st_news', function (Blueprint $table) {
            $table->dropForeign(['cat_id']); // Удаляем внешний ключ
            $table->dropColumn('cat_id'); // Удаляем столбец cat_id
        });
    }
};
