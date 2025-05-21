<?php

namespace App\Http\Requests\Dashboard\Seo;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreSeoRequest extends FormRequest
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
        $rules =  [
            "slug" => ["required", "string", "max:255", Rule::unique("seos", "slug")->whereNull("deleted_at")],
            "page_name" => "required|string|max:255",
            "is_active" => "nullable|boolean",
        ];


        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.meta_name"] = 'required|string';
            $rules["$locale.meta_description"] = 'required|string';
            $rules["$locale.meta_keywords"] = 'required|string';
        }

        return $rules;
    }

    public function prepareForValidation() : void
    {
        $this->merge([
            "slug" => Str::slug($this->slug),
        ]);
    }
}
