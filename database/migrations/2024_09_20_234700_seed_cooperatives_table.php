<?php

use App\Models\Cooperative;
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
        Cooperative::create([
            'name' => 'Старт-19',
            'coordinate_x' => 57.148610,
            'coordinate_y' => 65.594607,
            'description' => 'Приватизация проходит норм.',
            'status' => 'green',
            'is_visible' => true
        ]);

        Cooperative::create([
            'name' => 'ГАИ',
            'coordinate_x' => 57.148530,
            'coordinate_y' => 65.593498,
            'description' => 'Приватизация проходит норм.',
            'status' => 'green',
            'is_visible' => true
        ]);

        Cooperative::create([
            'name' => 'Корабельщик',
            'coordinate_x' => 57.155489,
            'coordinate_y' => 65.586492,
            'description' => 'Тут уже объявлено КРТ, приватизация строения через суд, землю делаем по гаражной амнистии, выделяется бесплатно.',
            'status' => 'yellow',
            'is_visible' => true
        ]);

        Cooperative::create([
            'name' => 'Нефтяник 20',
            'coordinate_x' => 57.151150,
            'coordinate_y' => 65.603835,
            'description' => 'Приватизация проходит норм.',
            'status' => 'green',
            'is_visible' => true
        ]);

        Cooperative::create([
            'name' => 'Восток 21',
            'coordinate_x' => 57.150359,
            'coordinate_y' => 65.602964,
            'description' => 'Приватизация проходит норм.',
            'status' => 'green',
            'is_visible' => true
        ]);
        Cooperative::create([
            'name' => 'Алитет',
            'coordinate_x' => 57.131594,
            'coordinate_y' => 65.611721,
            'description' => 'Приватизация проходит норм.',
            'status' => 'green',
            'is_visible' => true
        ]);
        Cooperative::create([
            'name' => 'Дзержинец',
            'coordinate_x' => 57.1477,
            'coordinate_y' => 65.527741,
            'description' => 'Приватизация не проходит, есть ряд нерешённых юридических моментов',
            'status' => 'red',
            'is_visible' => true
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Cooperative::where('name', 'Старт-19')->delete();
        Cooperative::where('name', 'ГАИ')->delete();
        Cooperative::where('name', 'Корабельщик')->delete();
        Cooperative::where('name', 'Нефтяник 20')->delete();
        Cooperative::where('name', 'Восток 21')->delete();
        Cooperative::where('name', 'Дзержинец')->delete();
        Cooperative::where('name', 'Алитет')->delete();

    }
};
