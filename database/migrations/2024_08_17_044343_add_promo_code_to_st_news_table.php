<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('st_news', function (Blueprint $table) {
            $table->text('summary')->nullable()->after('title');
            $table->string('promo_code')->nullable()->after('summary');
        });
    }

    public function down(): void
    {
        Schema::table('st_news', function (Blueprint $table) {
            $table->dropColumn(['promo_code', 'summary']);
        });
    }
};
