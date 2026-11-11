<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('newsstorage_news', function (Blueprint $table) {
            $table->dropForeign(['source_id']);
            $table->unsignedBigInteger('source_id')->nullable()->change();
            $table->foreign('source_id')->references('id')->on('newsstorage_sources')->cascadeOnDelete();
            $table->string('url', 2048)->nullable()->change();
            $table->date('news_date')->nullable();
            $table->string('source', 2048)->nullable();
            $table->string('source_domain')->nullable();
            $table->string('promo_code')->nullable();
            $table->unsignedBigInteger('site_id')->nullable()->index();
            $table->unsignedBigInteger('cat_id')->nullable()->index();
            $table->boolean('moderation')->nullable();
            $table->boolean('moderation_required')->default(false);
            $table->dateTime('moderation_date')->nullable();
            $table->string('moderation_who')->nullable();
            $table->dateTime('told_at')->nullable();
            $table->unsignedBigInteger('cover_photo_id')->nullable();
            $table->unsignedBigInteger('legacy_st_news_id')->nullable()->unique();
            $table->boolean('is_stn')->default(false)->index();
        });

        Schema::table('st_news_media', function (Blueprint $table) {
            $table->unsignedBigInteger('newsstorage_news_id')->nullable()->index();
            $table->dropForeign(['st_news_id']);
            $table->unsignedBigInteger('st_news_id')->nullable()->change();
            $table->foreign('st_news_id')->references('id')->on('st_news')->cascadeOnDelete();
        });
        Schema::table('st_news_photos', function (Blueprint $table) {
            $table->unsignedBigInteger('newsstorage_news_id')->nullable()->index();
            $table->dropForeign(['st_news_id']);
            $table->unsignedBigInteger('st_news_id')->nullable()->change();
            $table->foreign('st_news_id')->references('id')->on('st_news')->cascadeOnDelete();
        });
        Schema::table('st_news_keywords', function (Blueprint $table) {
            $table->unsignedBigInteger('newsstorage_news_id')->nullable();
            $table->index('newsstorage_news_id');
            $table->dropForeign(['st_news_id']);
            $table->dropPrimary();
            $table->unsignedBigInteger('st_news_id')->nullable()->change();
            $table->foreign('st_news_id')->references('id')->on('st_news')->cascadeOnDelete();
            $table->unique(['st_news_id', 'keyword_id']);
        });
        Schema::table('newsstorage_video_blog_reads', function (Blueprint $table) {
            $table->unsignedBigInteger('newsstorage_news_id')->nullable()->unique();
        });

        $newsIds = [];
        foreach (DB::table('st_news')->orderBy('id')->get() as $oldNews) {
            $newsIds[$oldNews->id] = DB::table('newsstorage_news')->insertGetId([
                'source_id' => null,
                'url' => $oldNews->source,
                'title' => $oldNews->title,
                'summary' => $oldNews->summary,
                'content' => $oldNews->content,
                'status' => $oldNews->published_at ? 'published' : 'new',
                'status_show' => null,
                'published_at' => $oldNews->published_at,
                'news_date' => $oldNews->news_date,
                'source' => $oldNews->source,
                'source_domain' => $oldNews->source_domain,
                'promo_code' => $oldNews->promo_code,
                'site_id' => $oldNews->site_id,
                'cat_id' => $oldNews->cat_id,
                'moderation' => $oldNews->moderation,
                'moderation_required' => $oldNews->moderation_required,
                'moderation_date' => $oldNews->moderation_date,
                'moderation_who' => $oldNews->moderation_who,
                'told_at' => $oldNews->told_at,
                'cover_photo_id' => $oldNews->cover_photo_id,
                'legacy_st_news_id' => $oldNews->id,
                'is_stn' => true,
                'created_at' => $oldNews->created_at,
                'updated_at' => $oldNews->updated_at,
                'deleted_at' => $oldNews->deleted_at,
                'is_featured' => false,
                'featured_at' => null,
            ]);
        }

        foreach (DB::table('st_news_media')->get(['id', 'st_news_id']) as $media) {
            DB::table('st_news_media')->where('id', $media->id)
                ->update(['newsstorage_news_id' => $newsIds[$media->st_news_id]]);
        }
        foreach (DB::table('st_news_photos')->get(['id', 'st_news_id']) as $photo) {
            DB::table('st_news_photos')->where('id', $photo->id)
                ->update(['newsstorage_news_id' => $newsIds[$photo->st_news_id]]);
        }
        foreach (DB::table('st_news_keywords')->get(['st_news_id', 'keyword_id']) as $keyword) {
            DB::table('st_news_keywords')->where('st_news_id', $keyword->st_news_id)
                ->where('keyword_id', $keyword->keyword_id)
                ->update(['newsstorage_news_id' => $newsIds[$keyword->st_news_id]]);
        }
        foreach (DB::table('newsstorage_video_blog_reads')->get(['id', 'news_id', 'st_news_id']) as $read) {
            $newsId = $read->st_news_id !== null
                ? $newsIds[$read->st_news_id]
                : $read->news_id;
            if ($newsId !== null) {
                DB::table('newsstorage_video_blog_reads')->where('id', $read->id)
                    ->update(['newsstorage_news_id' => $newsId]);
            }
        }

        Schema::table('st_news_keywords', function (Blueprint $table) {
            $table->foreign('newsstorage_news_id')->references('id')->on('newsstorage_news')->cascadeOnDelete();
            $table->unique(['newsstorage_news_id', 'keyword_id']);
        });
        Schema::table('newsstorage_video_blog_reads', function (Blueprint $table) {
            $table->foreign('newsstorage_news_id')->references('id')->on('newsstorage_news')->cascadeOnDelete();
        });
        Schema::table('newsstorage_news', function (Blueprint $table) {
            $table->foreign('site_id')->references('id')->on('st_news_parsing_site')->nullOnDelete();
            $table->foreign('cat_id')->references('id')->on('st_news_parsing_category')->nullOnDelete();
            $table->foreign('cover_photo_id')->references('id')->on('st_news_media')->nullOnDelete();
        });
    }

    public function down(): void
    {
        throw new RuntimeException('News records have been copied into News Storage. This migration cannot be rolled back automatically.');
    }
};
