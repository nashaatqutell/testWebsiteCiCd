<?php

namespace App\Http\Requests\Dashboard\About;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutRequest extends FormRequest
{


    public function rules(): array
    {
        $rules = [
            'type' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'org_structure' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:8000',
            'org_structure_ar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:8000',
            'is_active' => 'nullable|boolean',

        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'nullable|string|max:255';
            $rules["$locale.description"] = 'nullable|string|max:999999';
            $rules["$locale.meta_title"] = 'nullable|string|max:999';
            $rules["$locale.meta_description"] = 'nullable|string|max:999';
        }
        return $rules;
    }
}
