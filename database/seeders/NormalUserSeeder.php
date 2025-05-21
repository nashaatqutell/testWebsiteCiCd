<?php

namespace Database\Seeders;

use App\Enums\User\RoleEnum;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class NormalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {

            User::query()->create([
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                "password" => bcrypt('password'),
                "role" => RoleEnum::User->value,
                'created_at' => Carbon::now(),
            ]);
        }

    }
}
