<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cups', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->string('lat')->nullable();
            $table->string('lon')->nullable();

            $table->text('opis')->nullable();

            for ($i = 1; $i <= 10; $i++) {
                $table->string('img'.$i)->nullable();
            }

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cups');
    }
};
