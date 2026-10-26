<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * «Фото в самой новости» — ссылка на главное (обложка) медиа из st_news_media.
     */
    public function up(): void
    {
        Schema::table('st_news', function (Blueprint $table) {
            $table->unsignedBigInteger('cover_photo_id')->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('st_news', function (Blueprint $table) {
            $table->dropColumn('cover_photo_id');
        });
    }
};
