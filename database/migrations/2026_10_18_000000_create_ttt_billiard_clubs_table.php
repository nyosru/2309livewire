<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ttt_billiard_clubs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('address');
            $table->string('hours');
            $table->string('image_path')->nullable();
            $table->string('map_url', 2048);
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        $mapUrl = static fn (string $query): string => 'https://2gis.ru/tyumen/search/'.rawurlencode($query);
        $now = now();

        DB::table('ttt_billiard_clubs')->insert([
            [
                'name' => 'Шаровня',
                'type' => 'Русский бильярд · пул',
                'address' => 'ул. Александра Логунова, 11/2',
                'hours' => 'ежедневно 14:00–02:00',
                'image_path' => '/ttt/img/bar777-ball-colorful-photo-lg.jpeg',
                'map_url' => $mapUrl('Шаровня Тюмень Александра Логунова 11/2'),
                'sort_order' => 10,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Жеглов',
                'type' => 'Русский бильярд · пул',
                'address' => 'ул. Ленина, 4',
                'hours' => 'ежедневно 12:00–02:00',
                'image_path' => '/ttt/img/bill.webp',
                'map_url' => $mapUrl('Жеглов бильярд Тюмень Ленина 4'),
                'sort_order' => 20,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Академия бильярда',
                'type' => 'Русский бильярд · VIP-зал',
                'address' => 'ул. Энергетиков, 44а',
                'hours' => 'ежедневно 12:00–01:00',
                'image_path' => '/ttt/img/scale_1200.jpeg',
                'map_url' => $mapUrl('Академия бильярда Тюмень Энергетиков 44а'),
                'sort_order' => 30,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Пирамида',
                'type' => 'Русский бильярд · магазин',
                'address' => 'ул. Холодильная, 19, 7 этаж',
                'hours' => 'ежедневно 10:00–02:00',
                'image_path' => '/ttt/img/bb1.jpeg',
                'map_url' => $mapUrl('Пирамида бильярд Тюмень Холодильная 19'),
                'sort_order' => 40,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Премиум Люкс',
                'type' => 'Русский бильярд · VIP-комнаты',
                'address' => 'ул. Володарского, 14, 2 этаж',
                'hours' => 'ежедневно 14:00–02:00',
                'image_path' => '/ttt/img/m2.webp',
                'map_url' => $mapUrl('Премиум Люкс бильярд Тюмень Володарского 14'),
                'sort_order' => 50,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => '8:0',
                'type' => 'Русский бильярд · пул · ресторан',
                'address' => 'ул. Мельникайте, 116 к1, цоколь',
                'hours' => 'ежедневно 10:00–03:00',
                'image_path' => '/ttt/img/m3.webp',
                'map_url' => $mapUrl('8:0 бильярдный клуб Тюмень Мельникайте 116'),
                'sort_order' => 60,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('ttt_billiard_clubs');
    }
};
