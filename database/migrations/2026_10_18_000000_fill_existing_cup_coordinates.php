<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $locations = [
            'пгт Боровский' => ['57.028187', '65.646668'],
            'Москва' => ['55.755864', '37.617698'],
            'Сургут' => ['61.250000', '73.416670'],
            'ПортАвентура, Испания' => ['41.086839', '1.157272'],
        ];

        foreach ($locations as $name => [$latitude, $longitude]) {
            DB::table('cups')
                ->where('name', $name)
                ->where(function ($query): void {
                    $query->whereNull('lat')->orWhere('lat', '');
                })
                ->where(function ($query): void {
                    $query->whereNull('lon')->orWhere('lon', '');
                })
                ->update([
                    'lat' => $latitude,
                    'lon' => $longitude,
                ]);
        }
    }

    public function down(): void
    {
        // Existing coordinates may have been edited after this migration,
        // so rolling back must not erase user data.
    }
};
