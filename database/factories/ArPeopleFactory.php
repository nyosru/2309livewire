<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArPricece>
 */
class ArPeopleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'phone' => '89'.rand(111111111,999999999),
            'phone2' => rand(1,2) == 2 ? '89'.rand(111111111,999999999) : null,
            'opis' => fake()->text()
        ];
    }
}
