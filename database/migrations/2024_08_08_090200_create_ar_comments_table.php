<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ar_comments', function (Blueprint $table) {
            $table->id();
            $table->text('comment');
            $table->foreignId('ar_object_id')->constrained('ar_objects');
            $table->foreignId('ar_people_id')->nullable()->constrained('ar_peoples');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ar_comments');
    }
};
