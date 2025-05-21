<?php

namespace Database\Seeders;

use App\Models\Setting\Setting;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        \Schema::disableForeignKeyConstraints();
        \DB::table('settings')->truncate();
        \DB::table('setting_translations')->truncate();
        $faker = Factory::create();

        $setting = Setting::query()->create([
            "email" => $faker->email,
            "phone" => $faker->phoneNumber,
            "phone2" => $faker->phoneNumber,
            "support_phone" => $faker->phoneNumber,
            "location" => $faker->url,
            "facebook" => $faker->url,
            "whatsapp" => $faker->url,
            "instagram" => $faker->url,
            "youtube" => $faker->url,
            "tiktok" => $faker->url,
            "x" => $faker->url,
            "embed_map" => $faker->url,
            "en" => [
                "name" => "settingName",
                "description" => "settingDescription",
                "notes_and_suggestions" => "settingNotesAndSuggestions",
            ],
            "ar" => [
                "name" => "اسم الاعدادات",
                "description" => "وصف الاعدادات",
                "notes_and_suggestions" => "الملاحظات و الاقتراحات",
            ]
        ]);
    }
}
