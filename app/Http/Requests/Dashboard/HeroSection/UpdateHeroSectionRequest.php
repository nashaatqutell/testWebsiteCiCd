<?php

namespace App\Http\Requests\Dashboard\HeroSection;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHeroSectionRequest extends FormRequest
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:40960',
            'is_active' => 'nullable|boolean',
            'media_type' => 'nullable|in:image,video'
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'sometimes|string|max:255';
            $rules["$locale.description"] = 'sometimes|string';
            $rules["$locale.sub_description"] = 'sometimes|string';
        }
        return $rules;
    }
}
