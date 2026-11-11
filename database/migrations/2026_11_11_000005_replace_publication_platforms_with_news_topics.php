<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_topics', function (Blueprint $table) {
            $table->id();
            $table->string('name_ru')->unique();
            $table->string('name_en')->unique();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('news_topic_news', function (Blueprint $table) {
            $table->foreignId('news_id')->constrained('newsstorage_news')->cascadeOnDelete();
            $table->foreignId('topic_id')->constrained('news_topics')->cascadeOnDelete();
            $table->timestamps();
            $table->primary(['news_id', 'topic_id']);
        });

        $topicIds = [];
        foreach (DB::table('news_publication_platforms')->orderBy('id')->get() as $platform) {
            $englishName = match ($platform->domain) {
                'ПриватизацияГаража.рф' => 'Garage Privatization',
                'ЗемельныйКадастр.рф' => 'Land Cadastre',
                default => $platform->topic,
            };

            $topicIds[$platform->id] = DB::table('news_topics')->insertGetId([
                'name_ru' => $platform->topic,
                'name_en' => $englishName,
                'is_active' => $platform->is_active,
                'created_at' => $platform->created_at,
                'updated_at' => $platform->updated_at,
            ]);
        }

        foreach (DB::table('news_publications')->where('status', '!=', 'deleted')->get() as $publication) {
            if (! isset($topicIds[$publication->platform_id])) {
                continue;
            }

            DB::table('news_topic_news')->insertOrIgnore([
                'news_id' => $publication->news_id,
                'topic_id' => $topicIds[$publication->platform_id],
                'created_at' => $publication->created_at,
                'updated_at' => $publication->updated_at,
            ]);
        }

        Schema::dropIfExists('news_publications');
        Schema::dropIfExists('news_publication_platforms');
    }

    public function down(): void
    {
        throw new RuntimeException('News categories have replaced publication platforms. This migration cannot be rolled back automatically.');
    }
};
