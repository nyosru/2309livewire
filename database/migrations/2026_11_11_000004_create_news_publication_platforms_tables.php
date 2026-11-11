<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_publication_platforms', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->unique();
            $table->string('api_url', 2048)->nullable();
            $table->string('api_instructions_url', 2048)->nullable();
            $table->string('topic');
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('news_publications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->constrained('newsstorage_news')->cascadeOnDelete();
            $table->foreignId('platform_id')->constrained('news_publication_platforms')->cascadeOnDelete();
            $table->string('status', 20)->default('new')->index();
            $table->timestamps();
            $table->unique(['news_id', 'platform_id']);
        });

        DB::table('news_publication_platforms')->insert([
            [
                'domain' => 'ПриватизацияГаража.рф',
                'api_url' => null,
                'api_instructions_url' => null,
                'topic' => 'Приватизация гаража',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'domain' => 'ЗемельныйКадастр.рф',
                'api_url' => null,
                'api_instructions_url' => null,
                'topic' => 'Земельный кадастр',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('news_publications');
        Schema::dropIfExists('news_publication_platforms');
    }
};
