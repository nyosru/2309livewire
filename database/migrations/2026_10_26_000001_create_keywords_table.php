<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ключевые слова новостей (существительные / глаголы).
     * Общие для многих новостей (many-to-many через st_news_keywords).
     * name — нормальная (лемма) форма слова, уникальна.
     */
    public function up(): void
    {
        Schema::create('keywords', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('news_count')->default(0); // денорм.: сколько новостей используют слово
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keywords');
    }
};
