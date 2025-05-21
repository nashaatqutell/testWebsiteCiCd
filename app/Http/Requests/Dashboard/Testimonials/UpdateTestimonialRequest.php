<?php

namespace App\Http\Requests\Dashboard\Testimonials;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTestimonialRequest extends FormRequest
{

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'is_active' => 'nullable|boolean'
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.description"] = 'required|string|max:999999';
        }
        return $rules;
    }
}
