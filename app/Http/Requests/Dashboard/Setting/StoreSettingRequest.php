<?php

namespace App\Http\Requests\Dashboard\Setting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {


        $rules = [
            "email" => ["nullable","email"],
            "phone" => [
                "nullable",
                "different:phone2",
                "regex:/^\+?[0-9\s\-]{7,15}$/", // Valid phone number format with optional country code
            ],
            "phone2" => [
                "nullable",
                "different:phone",
                "regex:/^\+?[0-9\s\-]{7,15}$/",
            ],
            "support_phone" => [
                "nullable",
                "different:phone",
                "regex:/^\+?[0-9\s\-]{7,15}$/",
            ],
            "logo" => "nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,pdf|max:8000",
            "logo2" => "nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,pdf|max:8000",
            "footer_image" => "nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,pdf|max:8000",
            "financial_menus_image" => "nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,pdf|max:8000",
            "favicon" => "nullable|file|mimes:jpeg,png,jpg,gif,svg,webp,pdf|max:8000",
            "location" => "nullable|url",
            "embed_map" => "nullable|string",
            "facebook" => "nullable|url",
            "x" => "nullable|url",
            "instagram" => "nullable|url",
            "whatsapp" => "nullable|string",
            "youtube" => "nullable|url",
            "tiktok" => "nullable|url",
            "is_active" => "nullable|boolean",
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'nullable|string';
            $rules["$locale.description"] = 'nullable|string';
            $rules["$locale.notes_and_suggestions"] = 'nullable|string';
            $rules["$locale.footer_description"] = 'nullable|string';
            $rules["$locale.footer_description2"] = 'nullable|string';
            $rules["$locale.address"] = 'nullable|string';
        }

        return $rules;

    }
}
