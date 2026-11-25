<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vk_author_video_daily_snapshots', function (Blueprint $table): void {
            $table->id();
            $table->date('snapshot_date');
            $table->string('media_type', 20);
            $table->string('owner_id', 24);
            $table->string('video_id', 32);
            $table->string('title', 500);
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedInteger('duration')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('thumbnail_url', 1000)->nullable();
            $table->string('video_url', 1000);
            $table->dateTime('captured_at')->nullable();
            $table->timestamps();

            $table->unique(['snapshot_date', 'media_type', 'owner_id', 'video_id'], 'vk_author_daily_media_unique');
            $table->index(['snapshot_date', 'media_type', 'views'], 'vk_author_daily_type_views_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vk_author_video_daily_snapshots');
    }
};
