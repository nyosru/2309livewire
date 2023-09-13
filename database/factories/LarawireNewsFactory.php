<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LarawireNews>
 */
class LarawireNewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name(),
            'text' => $this->faker->text(500),
            'photo' => $this->faker->name(),
            'add_d' => date('Y-m-d',time()-(3600*rand(1,9999))+(3600*rand(1,9999)))
        ];
    }
}
