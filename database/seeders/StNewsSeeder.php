<?php

namespace Database\Seeders;

use App\Models\StNews;
use Illuminate\Database\Seeder;

class StNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StNews::factory()->count(30)->create();
    }
}
