<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bu_ads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('category_id');
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->string('contact_kind', 32)->nullable();
            $table->string('contact_value', 255)->nullable();
            $table->enum('status', ['published', 'draft', 'closed'])->default('published');
            $table->boolean('is_approved')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->integer('views')->default(0);
            $table->string('ip', 45)->nullable();
            $table->string('slug', 255)->unique()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('bu_ad_types')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('bu_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bu_ads');
    }
};
