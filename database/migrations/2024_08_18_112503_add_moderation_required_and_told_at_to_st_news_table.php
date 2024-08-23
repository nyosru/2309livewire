<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('st_news', function (Blueprint $table) {
            $table->boolean('moderation_required')->default(false)->comment('Требуется ли модерация');
            $table->date('told_at')->nullable()->comment('Дата, когда новость была рассказана');
        });
    }

    public function down(): void
    {
        Schema::table('st_news', function (Blueprint $table) {
            $table->dropColumn('moderation_required');
            $table->dropColumn('told_at');
        });
    }
};
