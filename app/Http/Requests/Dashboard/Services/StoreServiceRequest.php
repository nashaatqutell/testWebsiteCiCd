<?php

namespace App\Http\Requests\Dashboard\Services;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:10240',
            "parent_id" => "nullable|exists:services,id",
            'is_active' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string|max:255';
            $rules["$locale.description"] = 'required|string';
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
