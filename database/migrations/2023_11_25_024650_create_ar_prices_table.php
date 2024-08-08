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
        Schema::create('ar_prices', function (Blueprint $table) {

            $table->id();

            $table->foreignId('ar_object_id')->constrained()->onDelete('cascade');
            $table->foreignId('ar_people_id')->constrained()->onDelete('cascade');

            $table->unsignedDecimal('price')->comment('цена');
            $table->date('date_start');
            $table->text('opis')->nullable();

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ar_prices');
    }
};
