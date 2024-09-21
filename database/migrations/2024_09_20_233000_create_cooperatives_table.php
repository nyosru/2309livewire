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
        Schema::create('cooperatives', function (Blueprint $table) {
            $table->id();
            $table->string('name');               // Название кооператива
            $table->decimal('coordinate_x', 10, 6); // Координата x (широта)
            $table->decimal('coordinate_y', 10, 6); // Координата y (долгота)
            $table->text('description');          // Описание кооператива
            $table->enum('status', ['green', 'yellow', 'red']); // Статус (зелёный/жёлтый/красный)
            $table->boolean('is_visible')->default(true); // Статус видимости (по умолчанию да)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooperatives');
    }
};
