<?php

namespace App\Http\Requests\Dashboard\Faqs;

use Illuminate\Foundation\Http\FormRequest;

class StoreFaqRequest extends FormRequest
{

    public function rules(): array
    {
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.question"] = 'required|string|max:255';
            $rules["$locale.answer"] = 'required|string|max:255';
        }
        return $rules;
    }
}
