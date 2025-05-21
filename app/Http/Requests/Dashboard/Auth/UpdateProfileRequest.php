<?php

namespace App\Http\Requests\Dashboard\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "nullable|string|max:255",
            "email" => ["nullable", "email", "max:255", Rule::unique('users', 'email')->ignore($this->user())],
            "password" => "nullable|string|min:8|confirmed",
            "phone" => ["nullable", Rule::unique("users", "phone")->ignore($this->user())],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
        ];
    }
}
