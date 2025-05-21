<?php

namespace Database\Seeders;

use App\Models\HeroSection\HeroSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeroSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $heroSections = [
            [
                'is_active' => true,
                'added_by_id' => 1,
                'translations' => [
                    'en' => [
                        'name' => 'Welcome to Our Website',
                        'sub_description' => 'Discover amazing content and join our community today.',
                        'description' => 'Discover amazing content and join our community today.'
                    ],
                    'ar' => [
                        'name' => 'مرحبًا بكم في موقعنا',
                        'sub_description' => 'اكتشف محتوى رائعًا وانضم إلى مجتمعنا اليوم.',
                        'description' => 'اكتشف محتوى رائعًا وانضم إلى مجتمعنا اليوم.',
                    ]
                ],
            ],
        ];

        foreach ($heroSections as $heroSectionData) {
            $translations = $heroSectionData['translations'];
            unset($heroSectionData['translations']);
            $heroSection = HeroSection::create($heroSectionData);
            $heroSection->update($translations);
        }
    }
}
