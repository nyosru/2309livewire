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
            $table->unsignedInteger('time_to_auto_publish')->nullable()->after('category_parsing_url')
                ->comment('Время до автопубликации в минутах');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('st_news_parsing_site', function (Blueprint $table) {
            $table->dropColumn('time_to_auto_publish');
        });
    }
};
