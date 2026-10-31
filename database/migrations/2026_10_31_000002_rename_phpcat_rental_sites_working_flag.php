<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('phpcat_rental_sites', function (Blueprint $table) {
            $table->renameColumn('is_working', 'is_rented');
        });
    }

    public function down(): void
    {
        Schema::table('phpcat_rental_sites', function (Blueprint $table) {
            $table->renameColumn('is_rented', 'is_working');
        });
    }
};
