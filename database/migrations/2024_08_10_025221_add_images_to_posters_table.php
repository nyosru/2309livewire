<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posters', function (Blueprint $table) {
            $table->json('images')->nullable();  // Поле для хранения ссылок на изображения
        });
    }

    public function down()
    {
        Schema::table('posters', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};
