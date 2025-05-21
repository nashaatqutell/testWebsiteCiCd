<?php

namespace App\Http\Requests\Dashboard\Roles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
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
            "name" => ["nullable", Rule::unique('roles', 'name')->ignore($this->role)],
            "permission" => "nullable|array",
            "permission.*" => "nullable|exists:permissions,id|distinct|string",
        ];
    }
}
