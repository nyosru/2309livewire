<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vk_manager_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('vk_friend_id');
            $table->boolean('is_favorite')->default(false);
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'vk_friend_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vk_manager_contacts');
    }
};
