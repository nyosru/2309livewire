<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * published_at становится nullable:
     *   NULL  — черновик, новость скрыта от посетителей;
     *   задаём дату/время — новость становится видна на сайте.
     */
    public function up(): void
    {
        Schema::table('st_news', function (Blueprint $table) {
            $table->dateTime('published_at')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('st_news', function (Blueprint $table) {
            $table->dateTime('published_at')->nullable(false)->change();
        });
    }
};
