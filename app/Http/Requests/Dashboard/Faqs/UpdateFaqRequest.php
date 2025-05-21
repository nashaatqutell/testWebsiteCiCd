<?php

namespace App\Http\Requests\Dashboard\Faqs;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFaqRequest extends FormRequest
{

    public function rules(): array
    {
        $data = [
            "is_active" => "nullable|boolean",
        ];
        foreach (config('translatable.locales') as $locale) {
            $data["$locale.question"] = 'required|string|max:255';
            $data["$locale.answer"] = 'required|string|max:255';
        }
        return $data;
    }
}
