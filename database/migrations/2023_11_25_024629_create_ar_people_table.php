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
        Schema::create('ar_peoples', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->string('phone');

            $table->string('phone2')->nullable();
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
        Schema::dropIfExists('ar_peoples');
//        Schema::dropIfExists('ar_peoples');
    }
};
