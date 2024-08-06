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

//            $table->unsignedBigInteger('ar_price_id');
//            $table->foreign('ar_price_id')->references('id')->on('ar_prices');

//            $table->foreignId('ar_object_id')->constrained();
//            $table->foreignId('ar_people_id')->constrained();
            $table->foreignId('ar_object_id')->constrained()->onDelete('cascade');
            $table->foreignId('ar_people_id')->constrained()->onDelete('cascade');

            $table->integer('price');
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
