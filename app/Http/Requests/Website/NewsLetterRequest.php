<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class NewsLetterRequest extends FormRequest
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
            "email" => "nullable|email",
            "phone" => "nullable|string",
            "name" => "required|string",
        ];
    }
}
