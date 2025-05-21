<?php

namespace App\Http\Requests\Dashboard\Seo;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateSeoRequest extends FormRequest
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
            "slug" => ["nullable", Rule::unique('seos', 'slug')->ignore($this->seo)->whereNull("deleted_at")],
            "page_name" => "nullable|string|max:255",
            "is_active" => "nullable|boolean",
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.meta_name"] = 'nullable|string|max:255';
            $rules["$locale.meta_description"] = 'nullable|string';
            $rules["$locale.meta_keywords"] = 'nullable|string';
        }
        return $rules;
    }

    public function prepareForValidation() : void
    {
        $this->merge([
            "slug" => isset($this->slug) ? Str::slug($this->slug) : $this->seo->slug,
        ]);
    }
}
