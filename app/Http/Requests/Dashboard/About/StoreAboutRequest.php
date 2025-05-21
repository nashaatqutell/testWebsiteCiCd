<?php

namespace App\Http\Requests\Dashboard\About;

use Illuminate\Foundation\Http\FormRequest;

class StoreAboutRequest extends FormRequest
{

    public function rules(): array
    {
        $rules = [
            'type' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:8000',
            'org_structure' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:8000',
            'org_structure_ar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:8000',
            'is_active' => 'nullable|boolean'
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string|max:255';
            $rules["$locale.description"] = 'nullable|string|max:99999';
            $rules["$locale.meta_title"] = 'nullable|string|max:999';
            $rules["$locale.meta_description"] = 'nullable|string|max:999';
        }
        return $rules;
    }
}
