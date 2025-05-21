<?php

namespace Database\Seeders;

use App\Models\Partner\Partner;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            [
                'link' => 'https://example.com',
                'is_active' => true,
                'added_by_id' => 1,
                'translations' => [
                    'en' => [
                        'name' => 'Partner',
                    ],
                    'ar' => [
                        'name' => 'شريك',
                    ]
                ]
            ],
        ];

        foreach ($partners as $partnerData) {
            $translations = $partnerData['translations'];
            unset($partnerData['translations']);
            $partner = Partner::create($partnerData);
            $partner->update($translations);
        }
    }
    
}
