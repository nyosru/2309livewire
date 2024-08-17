<?php

namespace Database\Factories;

use App\Models\StNewsPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

class StNewsPhotoFactory extends Factory
{
    protected $model = StNewsPhoto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'image_path' => 'images/' . $this->faker->image('public/storage/images', 640, 480, null, false),
        ];
    }
}
