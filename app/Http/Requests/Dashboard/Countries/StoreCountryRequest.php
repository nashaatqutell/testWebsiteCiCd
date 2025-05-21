<?php

namespace App\Http\Requests\Dashboard\Countries;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'is_active' => 'nullable|boolean'
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string|max:255';
        }
        return $rules;
    }
}
