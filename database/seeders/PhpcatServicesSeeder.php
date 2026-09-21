<?php

namespace Database\Seeders;

use App\Models\PhpcatServices;
use Illuminate\Database\Seeder;

class PhpcatServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PhpcatServices::factory(10)->create();
    }
}
