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
        Schema::dropIfExists('afisha_images');
        Schema::create('afisha_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poster_id')->constrained('afisha_posters')->onDelete('cascade');
            $table->string('path'); // Путь к изображению
            $table->string('title')->nullable(); // подпись
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('afisha_images');
    }

};
