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
        Schema::table('st_news', function (Blueprint $table) {
            // Удаляем поле image_path
            $table->dropColumn('image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('st_news', function (Blueprint $table) {
            // Добавляем обратно поле image_path
            $table->string('image_path')->nullable();
        });
    }
};
