<?php

namespace App\Http\Requests\Dashboard\ResetPassword;

use Illuminate\Foundation\Http\FormRequest;

class RestPasswordRequest extends FormRequest
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
        return [
            "password" => "required|confirmed|min:8",
            "password_confirmation" => "required|min:8|same:password",
            "email" => "required|email|exists:users,email",
        ];
    }
}
