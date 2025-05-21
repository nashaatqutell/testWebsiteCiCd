<?php

namespace App\Http\Requests\Dashboard\Partner;

use Illuminate\Foundation\Http\FormRequest;

class StorePartnerRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'link' => 'nullable|url|string',
            'is_active' => 'nullable|boolean',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string|max:255';
        }
        return $rules;

    }
}
