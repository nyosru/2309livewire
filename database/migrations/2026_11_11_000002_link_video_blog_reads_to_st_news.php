<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('newsstorage_video_blog_reads', function (Blueprint $table) {
            $table->dropForeign(['news_id']);
            $table->dropUnique(['news_id']);
            $table->unsignedBigInteger('news_id')->nullable()->change();
            $table->foreign('news_id')->references('id')->on('newsstorage_news')->cascadeOnDelete();
            $table->foreignId('st_news_id')->nullable()->unique()->constrained('st_news')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('newsstorage_video_blog_reads', function (Blueprint $table) {
            $table->dropForeign(['st_news_id']);
            $table->dropUnique(['st_news_id']);
            $table->dropColumn('st_news_id');
            $table->dropForeign(['news_id']);
            $table->unsignedBigInteger('news_id')->nullable(false)->change();
            $table->unique('news_id');
            $table->foreign('news_id')->references('id')->on('newsstorage_news')->cascadeOnDelete();
        });
    }
};
