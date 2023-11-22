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
        Schema::create('vk_file_histories', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('vk_id');
            $table->bigInteger('vk_owner_id');
            $table->string('title');
            $table->string('ext', 10)->nullable();
            $table->string('url', 255)->nullable();
            $table->bigInteger('size')->nullable();
            $table->json('json')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vk_file_histories');
    }
};
