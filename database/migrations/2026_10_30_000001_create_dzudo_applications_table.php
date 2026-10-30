<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dzudo_applications', function (Blueprint $table) {
            $table->id();
            $table->uuid('reference')->unique();
            $table->text('phone');
            $table->string('source', 20);
            $table->timestamp('notified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dzudo_applications');
    }
};
