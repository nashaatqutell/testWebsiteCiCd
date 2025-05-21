<?php

namespace App\Http\Requests\Dashboard\Testimonials;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
{

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'is_active' => 'nullable|boolean',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.description"] = 'required|string|max:999999';
        }
        return $rules;
    }
}
