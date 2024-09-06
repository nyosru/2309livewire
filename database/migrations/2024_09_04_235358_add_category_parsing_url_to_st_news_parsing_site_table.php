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
        Schema::table('st_news_parsing_site', function (Blueprint $table) {
            $table->string('category_parsing_url')->nullable(); // Добавляем поле для ссылки

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('st_news_parsing_site', function (Blueprint $table) {
            $table->dropColumn('category_parsing_url'); // Удаляем поле при откате миграции

        });
    }
};
