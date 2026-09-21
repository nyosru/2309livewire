<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'newsstorage';

    public function up(): void
    {
        if (Schema::connection($this->connection)->hasColumn('newsstorage_news', 'status_show')) {
            return;
        }

        Schema::table('newsstorage_news', function (Blueprint $table) {
            $table->string('status_show')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('newsstorage_news', function (Blueprint $table) {
            $table->dropColumn('status_show');
        });
    }
};
