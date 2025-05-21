<?php

namespace App\Http\Requests\Dashboard\User;

use App\Enums\User\ActiveEnum;
use App\Enums\User\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
            "name" => "required|string",
            "email" => ["required", "email", Rule::unique("users", "email")->whereNull("deleted_at")],
            "phone" => ["required", Rule::unique("users", "phone")->whereNull("deleted_at")],
//            "password" => "required|string|min:8",
//            "password" => ['required', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
            "password" => ['required', "string","max:255","min:8"],
            "role" => ["nullable",new Enum(RoleEnum::class)],
            "added_by_id" => "nullable|exists:users,id",
            "is_active" => ["nullable",new Enum(ActiveEnum::class)],
//            "role_id" => ["required","exists:roles,id","distinct","numeric"],
        ];
    }

    public function prepareForValidation() : void
    {
        $this->merge([
            "added_by_id" => auth()->id(),
            "role" => $this->role ?? RoleEnum::User->value,
        ]);
    }
}
