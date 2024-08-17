<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('st_news', function (Blueprint $table) {
            $table->id();
            
            $table->string('title');
            $table->text('content');
            $table->date('published_at');
            $table->string('image_path')->nullable(); // Поле для фотографии, необязательное

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('st_news');
    }
};
