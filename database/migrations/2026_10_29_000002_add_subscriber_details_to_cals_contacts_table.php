<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cals_contacts', function (Blueprint $table) {
            $table->string('company_name')->nullable()->after('phone_normalized');
            $table->date('start_date')->nullable()->after('company_name');
        });
    }

    public function down(): void
    {
        Schema::table('cals_contacts', function (Blueprint $table) {
            $table->dropColumn(['company_name', 'start_date']);
        });
    }
};
