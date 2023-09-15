<?php

namespace Database\Seeders;

use App\Models\LarawireNews;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LarawireNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LarawireNews::factory(20)->create();
    }
}
