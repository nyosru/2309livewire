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
            // Добавляем поле site_id с внешним ключом на st_news_parsing_site
            $table->unsignedBigInteger('site_id')->nullable()->after('id');

            $table->foreign('site_id')
                ->references('id')
                ->on('st_news_parsing_site')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('st_news', function (Blueprint $table) {
            // Удаляем внешний ключ и поле site_id
            $table->dropForeign(['site_id']);
            $table->dropColumn('site_id');
        });
    }
};
