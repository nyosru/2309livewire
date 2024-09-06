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
        Schema::create('st_news_parsing_site', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор записи
            $table->string('site_name'); // Название сайта
            $table->string('site_url'); // URL сайта
            $table->timestamp('last_catalog_scan')->nullable(); // Дата и время последнего сканирования каталогов
            $table->timestamp('last_news_scan')->nullable(); // Дата и время последнего сканирования списка новостей
            $table->boolean('scan_status')->default(true); // Статус сканирования (включено/выключено)
            $table->softDeletes(); // Поле для мягкого удаления (soft delete)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('st_news_parsing_site');
    }
};
