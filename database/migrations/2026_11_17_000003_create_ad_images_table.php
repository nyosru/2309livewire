<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bu_ad_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ad_id');
            $table->string('url', 512);
            $table->boolean('is_main')->default(false);
            $table->integer('sort')->default(0);
            $table->foreign('ad_id')->references('id')->on('bu_ads')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bu_ad_images');
    }
};
