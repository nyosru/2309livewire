<?php

namespace Database\Factories;

use App\Models\StNews;
use Illuminate\Database\Eloquent\Factories\Factory;

class StNewsFactory extends Factory
{
    protected $model = StNews::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'summary' => $this->faker->paragraph,
            'content' => $this->faker->text,
            'published_at' => now(),
            'promo_code' => $this->faker->optional()->lexify('PROMO-????'), // Добавляем поле промокода
        ];
    }
}
