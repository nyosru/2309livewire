<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('max_recipients', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 16)->unique();
            $table->string('max_user_id', 20)->unique();
            $table->timestamps();
        });
        Schema::create('max_verifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('phone', 16);
            $table->string('purpose', 100)->index();
            $table->string('browser_hash', 64);
            $table->string('code_hash')->nullable();
            $table->unsignedTinyInteger('code_length')->default(6);
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->string('status', 20)->default('pending');
            $table->timestamp('expires_at')->index();
            $table->timestamp('consumed_at')->nullable();
            $table->timestamps();
        });
        Schema::create('vkusno_phone_administrators', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 16)->unique();
            $table->string('name', 100)->nullable();
            $table->foreignId('user_id')->nullable()->unique()->constrained('users')->nullOnDelete();
            $table->foreignId('granted_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
        Schema::table('vkusno_administrators', function (Blueprint $table) {
            $table->foreignId('granted_by_user_id')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('vkusno_administrators', function (Blueprint $table) {
            $table->dropConstrainedForeignId('granted_by_user_id');
        });
        Schema::dropIfExists('vkusno_phone_administrators');
        Schema::dropIfExists('max_verifications');
        Schema::dropIfExists('max_recipients');
    }
};
