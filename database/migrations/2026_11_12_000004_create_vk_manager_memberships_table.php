<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vk_manager_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained('vk_manager_accounts')->cascadeOnDelete();
            $table->foreignId('person_id')->constrained('vk_manager_people')->cascadeOnDelete();
            $table->string('status', 16); // friend | follower
            $table->boolean('is_current')->default(true);
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->string('source', 50)->default('vk_api');
            $table->timestamps();

            $table->index(['account_id', 'person_id', 'is_current'], 'vk_membership_current_person_idx');
            $table->index(['account_id', 'status', 'is_current'], 'vk_membership_current_status_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vk_manager_memberships');
    }
};
