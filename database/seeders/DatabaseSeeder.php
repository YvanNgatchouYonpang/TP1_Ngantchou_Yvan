<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Rental;
use App\Models\Review;
use App\Models\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SportSeeder::class,
            CategorySeeder::class,
            EquipmentSeeder::class,
            EquipmentSportSeeder::class,
        ]);
        User::factory()->count(10)->create();

        Rental::factory()->count(10)->create();

        Review::factory()->count(10)->create();

        Config::factory()->count(1)->create();
    }
}
