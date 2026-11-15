<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vk_manager_sync_runs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('account_id')->constrained('vk_manager_accounts')->cascadeOnDelete();
            $table->string('status', 20)->default('counting');
            $table->string('current_list', 20)->nullable();
            $table->unsignedInteger('current_page')->default(0);
            $table->unsignedInteger('error_page')->nullable();
            $table->string('error_list', 20)->nullable();
            $table->text('error_message')->nullable();
            $table->json('progress');
            $table->timestamp('next_request_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['account_id', 'status'], 'vk_sync_runs_account_status_idx');
        });

        Schema::create('vk_manager_sync_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('run_id')->constrained('vk_manager_sync_runs')->cascadeOnDelete();
            $table->string('list_name', 20);
            $table->string('vk_id', 20);
            $table->json('payload');
            $table->timestamps();

            $table->unique(['run_id', 'list_name', 'vk_id'], 'vk_sync_items_run_list_person_uq');
            $table->index(['run_id', 'list_name'], 'vk_sync_items_run_list_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vk_manager_sync_items');
        Schema::dropIfExists('vk_manager_sync_runs');
    }
};
