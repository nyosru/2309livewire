<?php

namespace Database\Factories;

use App\Models\StNews;
use App\Models\StNewsPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class StNewsFactory extends Factory
{
    protected $model = StNews::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(3, true),
            'published_at' => Carbon::now()->subDays(rand(0, 30)),
        ];
    }

    /**
     * Configure the factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (StNews $news) {
            // Добавляем 3 случайных фотографии для каждой новости
            StNewsPhoto::factory()->count(3)->create([
                'st_news_id' => $news->id,
                'image_path' => 'images/' . $this->faker->image('public/storage/images', 640, 480, null, false),
            ]);
        });
    }
}
