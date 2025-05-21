<?php

namespace App\Http\Requests\Dashboard\StaticPage;

use Illuminate\Foundation\Http\FormRequest;

class StoreStaticPageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
            $rules = [
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
                'is_active' => 'nullable|boolean',
            ];
            foreach (config('translatable.locales') as $locale) {
                $rules["$locale.name"] = 'required|string|max:255';
                $rules["$locale.description"] = 'required|string';
                $rules["$locale.meta_description"] = 'nullable|string';
            }
            return $rules;

    }
}
