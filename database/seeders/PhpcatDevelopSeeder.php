<?php

namespace Database\Seeders;

use App\Models\PhpcatDevelop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhpcatDevelopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PhpcatDevelop::factory(10)->create();
    }
}
