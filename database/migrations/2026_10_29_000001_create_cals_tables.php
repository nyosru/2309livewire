<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cals_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_normalized')->nullable()->unique();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('cals_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->nullable()->constrained('cals_contacts')->nullOnDelete();
            $table->string('phone')->nullable()->index();
            $table->dateTime('call_at')->index();
            $table->unsignedInteger('duration_seconds')->nullable();
            $table->longText('transcript')->nullable();
            $table->text('summary')->nullable();
            $table->json('metadata')->nullable();
            $table->string('source_path', 512)->nullable()->unique();
            $table->timestamps();
        });

        Schema::create('cals_contact_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained('cals_contacts')->cascadeOnDelete();
            $table->text('body');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cals_contact_comments');
        Schema::dropIfExists('cals_calls');
        Schema::dropIfExists('cals_contacts');
    }
};
