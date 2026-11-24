<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calls_recording_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('recording_key', 64)->unique();
            $table->string('status', 16)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calls_recording_statuses');
    }
};
