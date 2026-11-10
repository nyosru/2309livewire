<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('st_news', function (Blueprint $table) {
            $table->date('news_date')->nullable()->after('source')->index();
        });

        // Старые записи получают временное значение; далее дата уточняется по первоисточнику.
        DB::table('st_news')
            ->whereNull('news_date')
            ->whereNotNull('published_at')
            ->update(['news_date' => DB::raw('DATE(published_at)')]);
    }

    public function down(): void
    {
        Schema::table('st_news', function (Blueprint $table) {
            $table->dropIndex(['news_date']);
            $table->dropColumn('news_date');
        });
    }
};
