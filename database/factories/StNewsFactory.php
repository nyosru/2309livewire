<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StNews;

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
