<?php

namespace App\Http\Requests\Dashboard\Gallery;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGalleryRequest extends FormRequest
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
            "images" => "nullable|array",
            "images.*" => "nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240",
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
