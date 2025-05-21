<?php

namespace App\Http\Requests\Dashboard\Blogs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreBlogRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            "slug" => ["required", "string", "max:255", Rule::unique("blogs", "slug")->whereNull("deleted_at")],
            "image" => "required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240",
            "added_by_id" => "nullable|exists:users,id",
            "is_active" => "nullable|boolean",
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string';
            $rules["$locale.description"] = 'required|string';
        }
        return $rules;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            "added_by_id" => auth()->id(),
            "slug" => Str::slug($this->slug),
        ]);
    }
}
