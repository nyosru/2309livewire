<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raal_projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->default('Планируем');
            $table->string('status_color', 20)->default('lime');
            $table->text('description');
            $table->text('investment_offer');
            $table->json('images')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();

        DB::table('raal_projects')->insert([
            [
                'title' => 'ПроцессМастер',
                'category' => 'IT-сервис',
                'location' => 'Тюмень · Онлайн',
                'status' => 'Работает',
                'status_color' => 'lime',
                'description' => 'CRM и летопись бизнеса, в которой задачи, процессы и решения не теряются. Руководитель видит движение дел, команда — следующий шаг.',
                'investment_offer' => 'Вместе усилить продажи и вывести готовый продукт в новые отрасли. Обсудим модель участия и точки роста.',
                'images' => json_encode(['/processmaster/preview_link_for_fb.jpg', '/catcom/og-preview.png', '/phpcat/api.png'], JSON_UNESCAPED_UNICODE),
                'sort_order' => 10,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Катком',
                'category' => 'Бизнес-практика',
                'location' => 'Россия · Онлайн',
                'status' => 'Запускаем',
                'status_color' => 'orange',
                'description' => 'Практика постепенного планирования: человек видит прогресс, не перегружается и регулярно доводит дела до результата.',
                'investment_offer' => 'Упаковать методику в понятный продукт, проверить каналы продвижения и подготовить образовательную франшизу.',
                'images' => json_encode(['/catcom/og-preview.png', '/krostu/img/marketing.jpeg', '/phpcat/cloudman_02.png'], JSON_UNESCAPED_UNICODE),
                'sort_order' => 20,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Кружки Сергеича',
                'category' => 'Сообщество',
                'location' => 'Тюмень',
                'status' => 'Развиваем',
                'status_color' => 'blue',
                'description' => 'Коллекционный и событийный проект, который объединяет людей через необычные кружки, личные истории и живые встречи.',
                'investment_offer' => 'Развить мероприятия и мерч, проверить экономику клубной модели и подготовить формат к тиражированию.',
                'images' => json_encode(['/cups/preview_link_cups_for_fb.jpg', '/ttt/img/m3.webp', '/ttt/img/scale_1200.jpeg'], JSON_UNESCAPED_UNICODE),
                'sort_order' => 30,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('raal_projects');
    }
};
