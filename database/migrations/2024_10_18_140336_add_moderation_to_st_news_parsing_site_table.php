<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('st_news_parsing_site', function (Blueprint $table) {
            $table->boolean('moderation_on_upload')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('st_news_parsing_site', function (Blueprint $table) {
            $table->dropColumn('moderation_on_upload');
        });
    }
};
