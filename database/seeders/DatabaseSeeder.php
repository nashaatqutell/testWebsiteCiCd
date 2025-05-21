<?php

namespace Database\Seeders;

use App\Models\User;

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
            RoleSeeder::class,
            SettingSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
            ServiceSeeder::class,
            PartnerSeeder::class,
            SliderSeeder::class,
            HeroSectionSeeder::class,
            AboutSeeder::class
        ]);
    }
}
