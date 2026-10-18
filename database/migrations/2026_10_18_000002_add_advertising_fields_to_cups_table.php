<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cups', function (Blueprint $table) {
            $table->text('advertising_text')->nullable()->after('opis');
            $table->string('advertising_address', 500)->nullable()->after('advertising_text');
            $table->string('advertising_phone', 100)->nullable()->after('advertising_address');
            $table->boolean('show_advertisement')->default(false)->after('advertising_phone');
        });
    }

    public function down(): void
    {
        Schema::table('cups', function (Blueprint $table) {
            $table->dropColumn([
                'advertising_text',
                'advertising_address',
                'advertising_phone',
                'show_advertisement',
            ]);
        });
    }
};
