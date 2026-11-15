<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vk_manager_sync_pages', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('run_id')->constrained('vk_manager_sync_runs')->cascadeOnDelete();
            $table->string('list_name', 20);
            $table->unsignedInteger('page_number');
            $table->string('status', 20)->default('new');
            $table->text('error_message')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['run_id', 'list_name', 'page_number'], 'vk_sync_page_run_list_page_uq');
            $table->index(['run_id', 'status'], 'vk_sync_page_run_status_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vk_manager_sync_pages');
    }
};
