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
        Schema::create('redirect_hits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('redirect_id')->constrained('redirects')->onDelete('cascade'); // ID редиректа
            $table->ipAddress('ip_address'); // IP-адрес пользователя
            $table->timestamp('hit_at')->useCurrent(); // Время срабатывания редиректа

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redirect_hits');
    }
};
