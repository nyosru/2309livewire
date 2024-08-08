<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ar_pays', function (Blueprint $table) {
            $table->id();

            // Создание столбцов для внешних ключей
            $table->foreignId('ar_object_id')->constrained()->onDelete('cascade');
            $table->foreignId('ar_people_id')->constrained()->onDelete('cascade');

            $table->unsignedDecimal('amount')->comment('сумма платежа');
            $table->date('date')->comment('дата платежа');
            $table->text('opis')->nullable();
            $table->jsonb('json')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ar_pays', function (Blueprint $table) {
            // Удаление внешних ключей
            $table->dropForeign(['ar_object_id']);
            $table->dropForeign(['ar_people_id']);
        });

        Schema::dropIfExists('ar_pays');
    }
};
