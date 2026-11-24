<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calls_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('phone_normalized')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('calls_contact_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained('calls_contacts')->cascadeOnDelete();
            $table->text('body');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calls_contact_comments');
        Schema::dropIfExists('calls_contacts');
    }
};
