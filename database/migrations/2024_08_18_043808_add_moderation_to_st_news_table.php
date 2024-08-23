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
        Schema::table('st_news', function (Blueprint $table) {
            // Добавляем поле boolean для модерации
            $table->boolean('moderation')->nullable()->comment('Модерация спарсенных новостей: true - одобрено, false - отклонено, null - не модерировано');

            // Поле для даты модерации
            $table->date('moderation_date')->nullable()->comment('Дата модерации');

            // Поле для идентификатора пользователя, который модерировал новость
            $table->foreignId('moderation_who')->nullable()->constrained('users')->comment('ID пользователя, который модерировал');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('st_news', function (Blueprint $table) {
            // Удаляем добавленные столбцы при откате миграции
            $table->dropColumn('moderation');
            $table->dropColumn('moderation_date');
            $table->dropForeign(['moderation_who']);
            $table->dropColumn('moderation_who');
        });
    }
};
