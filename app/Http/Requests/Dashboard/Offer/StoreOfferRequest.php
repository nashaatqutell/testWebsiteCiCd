<?php

namespace App\Http\Requests\Dashboard\Offer;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
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
            "price" => "required|numeric",
            "discount_percent" => "required|numeric",
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string';
            $rules["$locale.description"] = 'required|string';
        }

        return $rules;
    }
}
