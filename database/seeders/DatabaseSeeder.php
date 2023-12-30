<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            ArObjectSeeder::class,
            ArPeopleSeeder::class,
            ArPriceSeeder::class,
            ArPaySeeder::class,

////            LarawireNewsSeeder::class,
//            PhpcatNewsSeeder::class,
//            PhpcatServicesSeeder::class,
            PhpcatDevelopSeeder::class
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
