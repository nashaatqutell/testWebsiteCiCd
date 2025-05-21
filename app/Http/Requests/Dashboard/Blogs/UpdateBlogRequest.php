<?php
namespace App\Http\Requests\Dashboard\Blogs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateBlogRequest extends FormRequest
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
            "slug"        => ["required", Rule::unique('blogs', 'slug')->ignore($this->blog)->whereNull("deleted_at")],
            "image"       => "nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240",
            "added_by_id" => "nullable|exists:users,id",
            "is_active"   => "nullable|boolean",

        ];

        foreach (config('translatable.locales') as $lang) {
            $data["$lang.name"]        = "nullable|string";
            $data["$lang.description"] = "nullable|string";
        }

        return $data;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            "added_by_id" => auth()->id(),
            "slug"        => isset($this->slug) ? Str::slug($this->slug) : $this->blog->slug,
        ]);
    }
}
