<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bu_ad_types', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 16)->unique()->index();
            $table->string('title_ru', 64);
            $table->string('icon', 32)->nullable();
            $table->boolean('is_visible')->default(true);
            $table->integer('sort')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bu_ad_types');
    }
};
