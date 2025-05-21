<?php

namespace App\Http\Requests\Dashboard\Roles;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $data = [
            "name" => "required|unique:roles,name",
            "permission" => "required|array",
            "permission.*" => "required|exists:permissions,id|distinct|string",
        ];

        return $data;
    }
}
