<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed culturals and related data
        $this->call([
            CulturalSeeder::class,
        ]);
        // Ensure an admin user exists for testing / development
        $this->call(AdminUserSeeder::class);

        // Seed geo data for culturals
        $this->call(CulturalGeoSeeder::class);
    }
}
