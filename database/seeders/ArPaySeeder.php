<?php

namespace Database\Seeders;

use App\Models\ArObject;
use App\Models\ArPay;
use App\Models\ArPeople;
use App\Models\ArPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ArPaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ArPay::factory(500)
            ->state(new Sequence(
                fn (Sequence $sequence) => [
                    'ar_object_id' => ArObject::all()->random(),
                    'ar_people_id' => ArPeople::all()->random()
                ],
            ))
            ->create();

    }
}
