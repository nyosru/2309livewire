<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Связь many-to-many: новость ↔ ключевые слова.
     */
    public function up(): void
    {
        Schema::create('st_news_keywords', function (Blueprint $table) {
            $table->foreignId('st_news_id')->constrained('st_news')->onDelete('cascade');
            $table->foreignId('keyword_id')->constrained('keywords')->onDelete('cascade');
            $table->primary(['st_news_id', 'keyword_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('st_news_keywords');
    }
};
