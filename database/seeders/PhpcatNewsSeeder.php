<?php

namespace Database\Seeders;

use App\Models\PhpcatNews;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhpcatNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PhpcatNews::factory(50)->create();
    }
}
