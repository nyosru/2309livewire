<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calls_branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('calls_branches')->restrictOnDelete();
            $table->string('name', 150);
            $table->string('type', 100);
            $table->string('project', 150);
            $table->timestamps();
        });
        DB::table('calls_branches')->insert([
            'name' => 'Базовая', 'type' => 'Основная', 'project' => 'Общее дерево',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        Schema::create('calls_recording_branches', function (Blueprint $table) {
            $table->id();
            $table->string('recording_key', 64)->unique();
            $table->foreignId('branch_id')->constrained('calls_branches')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calls_recording_branches');
        Schema::dropIfExists('calls_branches');
    }
};
