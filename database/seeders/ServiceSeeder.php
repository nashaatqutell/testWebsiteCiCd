<?php

namespace Database\Seeders;

use App\Models\Service\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'is_active' => true,
                'added_by_id' => 1,
                'translations' => [
                    'en' => [
                        'name' => 'Web Development',
                        'description' => 'Building and maintaining websites.'
                    ],
                    'ar' => [
                        'name' => 'تطوير الويب',
                        'description' => 'بناء وصيانة المواقع الإلكترونية.'
                    ]
                ],
            ],
        ];

        foreach ($services as $serviceData) {
            $translations = $serviceData['translations'];
            unset($serviceData['translations']);
            $service = Service::create($serviceData);
            $service->update($translations);
        }
    }
}
