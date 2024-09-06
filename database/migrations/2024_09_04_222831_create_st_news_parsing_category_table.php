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
        Schema::create('st_news_parsing_category', function (Blueprint $table) {
            $table->id(); // Уникальный идентификатор записи
            $table->foreignId('site_id') // Внешний ключ на сайт
            ->constrained('st_news_parsing_site')
                ->onDelete('cascade')
            ;
            $table->string('category_name'); // Название каталога
            $table->string('category_url'); // Ссылка на каталог
            $table->timestamp('last_scan')->nullable(); // Дата и время последнего сканирования
            $table->boolean('scan_status')->default(true); // Статус сканирования (вкл/выкл)
            $table->softDeletes(); // Поле для мягкого удаления (soft delete)
            $table->timestamps(); // Поля created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('st_news_parsing_category');
    }
};
