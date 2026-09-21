<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cup_photos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cup_id')->constrained()->cascadeOnDelete();
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->unsignedTinyInteger('sort')->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cup_photos');
    }
};
