<?php

namespace Database\Seeders;

use App\Models\ArObject;
use App\Models\ArPrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ArObjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ArObject::factory(50)
//            ->state(new Sequence(
//                fn (Sequence $sequence) => ['ar_price_id' => ArPrice::all()->random()],
//            ))
            ->create();
    }
}
