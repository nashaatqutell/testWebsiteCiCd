<?php

namespace App\Http\Requests\Dashboard\Gallery;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "images" => "required|array",
            "images.*" => "required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240",
            "added_by_id" => "nullable|exists:users,id",
        ];
    }

    public function prepareForValidation() : void
    {
        $this->merge([
            "added_by_id" => auth()->id(),
        ]);
    }
}
