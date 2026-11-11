<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsstorage_video_blog_reads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->unique()->constrained('newsstorage_news')->cascadeOnDelete();
            $table->date('read_at')->nullable();
            $table->unsignedInteger('number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsstorage_video_blog_reads');
    }
};
