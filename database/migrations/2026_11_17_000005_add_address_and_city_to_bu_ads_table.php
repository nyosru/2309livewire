<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bu_ads', function (Blueprint $table) {
            $table->string('address', 255)->nullable()->after('price');
            $table->string('city', 128)->nullable()->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('bu_ads', function (Blueprint $table) {
            $table->dropColumn(['address', 'city']);
        });
    }
};
