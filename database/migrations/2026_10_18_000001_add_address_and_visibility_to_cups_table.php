<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cups', function (Blueprint $table): void {
            $table->string('address')->nullable()->after('lon');
            $table->boolean('is_hidden')->default(false)->after('opis')->index();
        });
    }

    public function down(): void
    {
        Schema::table('cups', function (Blueprint $table): void {
            $table->dropIndex(['is_hidden']);
            $table->dropColumn(['address', 'is_hidden']);
        });
    }
};
