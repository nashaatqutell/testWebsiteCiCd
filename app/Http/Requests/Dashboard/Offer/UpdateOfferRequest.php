<?php

namespace App\Http\Requests\Dashboard\Offer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            "price" => "nullable|numeric",
            "discount_percent" => "nullable|numeric",
            "is_active" => "nullable|boolean",
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'nullable|string';
            $rules["$locale.description"] = 'nullable|string';
        }

        return $rules;
    }
}
