<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('st_news_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('st_news_id')->constrained()->onDelete('cascade'); // Внешний ключ на новость
            $table->string('image_path'); // Путь к изображению

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('st_news_photos');
    }
};
