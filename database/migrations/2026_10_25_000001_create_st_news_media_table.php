<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Единое хранилище фото и видео, привязанных к новости.
     * Не заменяет st_news_photos (его держит pipeline парсера), а добавляет
     * универсальную модель для фото + видео через API.
     */
    public function up(): void
    {
        Schema::create('st_news_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('st_news_id')->constrained('st_news')->onDelete('cascade');

            // photo | video
            $table->string('media_type')->default('photo')->index();

            // --- для фото ---
            $table->string('photo_path')->nullable(); // исходный URL или путь хранения
            $table->string('local_photo')->nullable(); // локальная копия (скачанная/загруженная)

            // --- для видео ---
            $table->string('video_url')->nullable();
            $table->string('provider')->nullable(); // youtube, vk, vimeo, rutube, dzen, tiktok, other
            $table->string('video_title')->nullable();
            $table->string('thumbnail_path')->nullable(); // обложка видео
            $table->unsignedInteger('duration')->nullable(); // секунды

            // --- общее ---
            $table->string('title')->nullable(); // подпись
            $table->string('alt')->nullable();
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('st_news_media');
    }
};
