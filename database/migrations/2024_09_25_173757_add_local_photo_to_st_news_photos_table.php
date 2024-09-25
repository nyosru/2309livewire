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
        Schema::table('st_news_photos', function (Blueprint $table) {
            $table->string('local_photo')->nullable(); // Новое поле для локальной фотки
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('st_news_photos', function (Blueprint $table) {
            $table->dropColumn('local_photo');
        });
    }
};
