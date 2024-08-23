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
            // Добавляем поле source
            $table->string('source')->nullable()->comment('Источник новости: ссылка или null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('st_news', function (Blueprint $table) {
            // Удаляем поле source при откате миграции
            $table->dropColumn('source');
        });
    }
};
