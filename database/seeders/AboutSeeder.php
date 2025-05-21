<?php

namespace Database\Seeders;

use App\Models\About\About;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Factory::create();
        About::query()->create([
            "en" => [
                "name" => $faker->name,
                "description" => $faker->text,
                "meta_title" => $faker->name,
                "meta_description" => $faker->text
            ],
            "ar" => [
                "name" => $faker->name,
                "description" => $faker->text,
                "meta_title" => $faker->name,
                "meta_description" => $faker->text
            ],
            "type" => "about"
        ]);
    }
}
