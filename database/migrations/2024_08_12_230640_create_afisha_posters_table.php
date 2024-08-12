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
        Schema::create('afisha_posters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('link')->nullable();
            $table->date('event_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('event_time')->nullable(); // Новое поле для времени проведения
            $table->string('source_link')->nullable();

            // Новые поля для дополнительных ссылок и подписей
            $table->json('extra_links')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('afisha_posters');
    }
};
