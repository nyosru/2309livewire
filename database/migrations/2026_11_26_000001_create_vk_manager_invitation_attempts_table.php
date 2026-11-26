<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vk_manager_invitation_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('vk_id', 20);
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->text('photo_url')->nullable();
            $table->timestamp('started_at');
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'vk_id'], 'vk_invite_attempt_user_vk_unique');
            $table->index(['user_id', 'resolved_at', 'started_at'], 'vk_invite_attempt_pending_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vk_manager_invitation_attempts');
    }
};
