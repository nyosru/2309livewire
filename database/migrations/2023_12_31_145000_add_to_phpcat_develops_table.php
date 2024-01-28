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
        Schema::table('phpcat_develops', function (Blueprint $table) {
            $table->string('github')->nullable();
            $table->string('packagist')->nullable();
            $table->text('how_start')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('phpcat_develops', function (Blueprint $table) {
            $table->dropColumn('github');
            $table->dropColumn('packagist');
            $table->dropColumn('how_start');
        });
    }
};
