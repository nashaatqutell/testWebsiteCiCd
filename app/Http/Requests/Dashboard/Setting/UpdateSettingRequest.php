<?php

namespace App\Http\Requests\Dashboard\Setting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules =  [
            "email" => ["nullable", "email",Rule::unique("settings", "email")->ignore($this->setting)],
            "phone" => ["nullable", Rule::unique("settings", "phone")->ignore($this->setting), "different:phone2"],
            "phone2" => ["nullable", Rule::unique("settings", "phone2")->ignore($this->setting), "different:phone"],
            "location" => ["nullable"],
            "embed_map" => ["nullable"],
            "facebook" => ["nullable"],
            "instagram" => ["nullable"],
            "youtube" => ["nullable"],
            "tiktok" => ["nullable"],
            "whatsapp" => ["nullable"],
            "x" => ["nullable"],
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'nullable|string';
            $rules["$locale.description"] = 'nullable|string';
        }

        return $rules;
    }
}
