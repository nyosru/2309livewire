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
        Schema::table('st_news_parsing_site', function (Blueprint $table) {
            $table->string('news_list_scan_key')->nullable();
            $table->string('single_news_scan_key')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('st_news_parsing_site', function (Blueprint $table) {
            $table->dropColumn('news_list_scan_key');
            $table->dropColumn('single_news_scan_key');
        });
    }
};
