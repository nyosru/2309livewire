<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vkusno_orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('reference')->unique();
            $table->string('name', 100);
            $table->string('phone', 30);
            $table->string('fulfillment', 20);
            $table->string('address', 500)->nullable();
            $table->date('requested_date')->nullable();
            $table->text('comment')->nullable();
            $table->json('items');
            $table->json('cake')->nullable();
            $table->unsignedInteger('subtotal');
            $table->unsignedInteger('delivery_fee')->nullable();
            $table->string('status')->default('new')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vkusno_orders');
    }
};
