<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calls_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('calls_recording_tags', function (Blueprint $table) {
            $table->id();
            $table->string('recording_basename');
            $table->foreignId('tag_id')->constrained('calls_tags')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['recording_basename', 'tag_id']);
            $table->index('recording_basename');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calls_recording_tags');
        Schema::dropIfExists('calls_tags');
    }
};
