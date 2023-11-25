<?php

namespace Database\Factories;

use App\Models\ArObject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArPricece>
 */
class ArObjectFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = ArObject::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomer' => rand(1,10),
            'adres' => fake()->name(),
            'opis' => fake()->text(),
//            'user_id' => rand(1,10)
//            'user_id' => rand(1,10)

        ];
    }
}
