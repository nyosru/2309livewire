<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'newsstorage';

    public function up(): void
    {
        Schema::connection($this->connection)->create('newsstorage_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->text('parsing_instructions')->nullable();
            $table->datetime('last_catalog_scan')->nullable();
            $table->timestamps();
        });

        Schema::connection($this->connection)->create('newsstorage_news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->constrained('newsstorage_sources')->cascadeOnDelete();
            $table->string('url');
            $table->string('title');
            $table->text('summary')->nullable();
            $table->longText('content')->nullable();
            $table->string('status')->default('new');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::connection($this->connection)->create('newsstorage_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->constrained('newsstorage_news')->cascadeOnDelete();
            $table->string('url');
            $table->string('type'); // image, video, json, other
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('newsstorage_media');
        Schema::connection($this->connection)->dropIfExists('newsstorage_news');
        Schema::connection($this->connection)->dropIfExists('newsstorage_sources');
    }
};
