<?php

namespace App\Http\Requests\Dashboard\Page;

use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
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
            'service_id' => 'required|exists:services,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'is_active' => 'nullable|boolean',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.title"] = 'required|string|max:255';
            $rules["$locale.description"] = 'required|string';
            $rules["$locale.meta_description"] = 'required|string';
        }
        return $rules;
    }

}
