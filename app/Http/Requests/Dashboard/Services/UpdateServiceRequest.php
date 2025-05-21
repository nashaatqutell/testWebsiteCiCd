<?php

namespace App\Http\Requests\Dashboard\Services;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'images' => ['nullable'],
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:10240',
            'is_active' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            "parent_id" => "nullable|exists:services,id"
        ];


        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'sometimes|string|max:255';
            $rules["$locale.description"] = 'sometimes|string';
        }
        return $rules;
    }

    public function prepareForValidation()
    {
        $this->merge([
            "parent_id" => $this->parent_id == "" ? null : $this->parent_id
        ]);
    }
}
