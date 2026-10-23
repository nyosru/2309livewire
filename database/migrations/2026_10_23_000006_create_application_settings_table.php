<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('application_settings', function (Blueprint $table) {
            $table->string('scope', 50)->primary();
            $table->text('values');
            $table->timestamps();
        });
        // Snapshot existing config/env values once, on the machine running this migration.
        foreach ([
            'vkusno' => ['phone', 'address', 'hours', 'timezone', 'map_url', 'directions_url', 'photos_url', 'seats', 'demo_menu', 'delivery_fee', 'cake_lead_days', 'fillings'],
            'max' => ['bot_token', 'bot_username', 'webhook_secret', 'webhook_url', 'auth_driver'],
        ] as $scope => $keys) {
            $values = [];
            foreach ($keys as $key) {
                $values[$key] = config($scope.'.'.$key);
            }
            DB::table('application_settings')->insert([
                'scope' => $scope, 'values' => Crypt::encryptString(json_encode($values, JSON_THROW_ON_ERROR)),
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('application_settings');
    }
};
