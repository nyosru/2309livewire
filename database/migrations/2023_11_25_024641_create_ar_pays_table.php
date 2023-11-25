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
        Schema::create('ar_pays', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ar_object_id')->constrained();
            $table->foreignId('ar_people_id')->constrained();

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
        Schema::dropIfExists('ar_pays');
    }
};
