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
        Schema::create('phpcat_develops', function (Blueprint $table) {
            $table->id();
            $table->string('system')->nullable();
            $table->string('title');
            $table->string('link')->nullable();
            $table->string('link_title')->nullable();
            $table->string('img_url')->nullable();
            $table->text('opis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phpcat_develops');
    }
};
