<?php
namespace App\Http\Requests\Dashboard\Categories;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
        $rules =  [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'is_active' => 'nullable|boolean',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"]= 'required|string|max:255';
            $rules["$locale.description"] = 'nullable|string';
        }
        return $rules;
    }
}
