<?php

namespace Database\Seeders;

use App\Models\Slider\Slider;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'is_active' => true,
                'added_by_id' => 1,
                'translations' => [
                    'en' => [
                        'name' => 'Summer Sale',
                        'description' => 'Enjoy up to 50% off on summer items!'
                    ],
                    'ar' => [
                        'name' => 'تخفيضات الصيف',
                        'description' => 'استمتع بخصم يصل إلى 50٪ على منتجات الصيف!'
                    ]
                ]
            ],
        ];

        foreach ($sliders as $sliderData) {
            $translations = $sliderData['translations'];
            unset($sliderData['translations']);
            $slider = Slider::create($sliderData);
            $slider->update($translations);
        }
    }
}
