<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach ([
            'vk_manager_profile_data',
            'vk_manager_education_data',
            'vk_manager_contact_data',
        ] as $tableName) {
            Schema::create($tableName, function (Blueprint $table) use ($tableName): void {
                $table->id();
                $table->foreignId('account_id')->constrained('vk_manager_accounts')->cascadeOnDelete();
                $table->foreignId('person_id')->constrained('vk_manager_people')->cascadeOnDelete();
                $table->json('data');
                $table->string('source', 50)->default('vk_api');
                $table->timestamp('obsolete_at')->nullable();
                $table->timestamps();

                $table->index(['account_id', 'person_id', 'obsolete_at'], $tableName.'_current_idx');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('vk_manager_contact_data');
        Schema::dropIfExists('vk_manager_education_data');
        Schema::dropIfExists('vk_manager_profile_data');
    }
};
