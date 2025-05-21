<?php

namespace App\Http\Requests\Dashboard\FinancialMenu;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFinancialMenuRequest extends FormRequest
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
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'file' => 'nullable|mimes:pdf|max:10240',
            'year' => 'nullable|date_format:Y',
            'is_active' => 'nullable|boolean',
            'added_by_id' => 'nullable|exists:users,id',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string|max:255';
        }
        return $rules;
    }
}
