<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vk_manager_people', function (Blueprint $table) {
            $table->id();
            $table->string('vk_id', 20)->unique();
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('display_name')->nullable();
            $table->string('domain', 100)->nullable();
            $table->text('photo_url')->nullable();
            $table->timestamp('last_profile_sync_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vk_manager_people');
    }
};
