<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bu_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedTinyInteger('level')->default(1);
            $table->string('title', 128);
            $table->string('slug', 192)->unique();
            $table->text('description')->nullable();
            $table->string('icon', 32)->nullable();
            $table->integer('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('meta_title', 192)->nullable();
            $table->text('meta_description')->nullable();
            $table->foreign('parent_id')
                ->references('id')->on('bu_categories')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bu_categories');
    }
};
