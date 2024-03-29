<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PhpcatDevelop>
 */
class PhpcatDevelopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'system' => $this->faker->name(),
            'title' => $this->faker->name(),

            'link' => $this->faker->url(),
            'link_title' => $this->faker->name(),

            'img_url' => $this->faker->imageUrl(150,150,null,true, 'test'),

            'opis' => $this->faker->text(500),


            'github' =>  $this->faker->url(),
            'packagist' => $this->faker->url(),

            'how_start' => $this->faker->text(500)

        ];
    }
}
