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
            // Убираем NOT NULL для полей content и published_at
            $table->text('content')->nullable()->change();
            $table->date('published_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('st_news', function (Blueprint $table) {
            // Возвращаем NOT NULL для полей content и published_at
            $table->text('content')->nullable(false)->change();
            $table->date('published_at')->nullable(false)->change();
        });
    }
};
