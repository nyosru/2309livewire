<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArPricece>
 */
class ArPayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
//            'price' => rand(1,10),
//            $table->foreignId('ar_object_id')->constrained();
//        $table->foreignId('ar_people_id')->constrained();
            'amount' => rand(20, 40) * 100,
            'date' => date('Y-m-d', $_SERVER['REQUEST_TIME'] - 3600 * 24 * 10 * rand(1, 50)),
//            'amount_opis' => 'asd',
//            'amount_json' => [1 => 2, 'asd' => 'asd']
        ];
    }
}
