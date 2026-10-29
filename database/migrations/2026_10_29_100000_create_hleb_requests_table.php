<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hleb_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('reference')->unique();
            $table->string('type', 20);
            $table->text('contact');
            $table->json('items');
            $table->unsignedInteger('total')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hleb_requests');
    }
};
