<?php

namespace App\Http\Requests\Dashboard\Employee;

use App\Enums\User\ActiveEnum;
use App\Enums\User\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class UpdateEmployeeRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "required|string",
            "email" => [
                "nullable",
                "email",
                Rule::unique('users', 'email')->ignore($this->employee)->whereNull("deleted_at")
            ],
            "phone" => ["nullable", Rule::unique('users', 'phone')->ignore($this->employee)->whereNull("deleted_at")],
            "password" => ['required', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
            "role" => ["nullable", new Enum(RoleEnum::class)],
            "added_by_id" => "nullable|exists:users,id",
            "is_active" => ["nullable", new Enum(ActiveEnum::class)],
            "role_id" => "nullable|exists:roles,id",
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            "added_by_id" => auth()->id(),
        ]);
    }
}
