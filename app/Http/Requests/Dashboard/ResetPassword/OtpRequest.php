<?php

namespace App\Http\Requests\Dashboard\ResetPassword;

use Illuminate\Foundation\Http\FormRequest;

class OtpRequest extends FormRequest
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
        $data = [
            "email" => "required|email|exists:users,email",
        ];

        if ($this->route()->getName() == "check_otp") {
            $data["code"] = "required|exists:users,code";
        }
        return $data;
    }
}
