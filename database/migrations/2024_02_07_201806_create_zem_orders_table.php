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
        Schema::create('zem_orders', function (Blueprint $table) {
            $table->id();

            $table->string('phone' );
            $table->string('name' );
            $table->string('city' );
            $table->string('kooperativ' );
            $table->string('nomer' );

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zem_orders');
    }
};
