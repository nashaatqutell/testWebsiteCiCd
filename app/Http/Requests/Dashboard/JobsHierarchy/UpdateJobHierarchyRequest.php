<?php
namespace App\Http\Requests\Dashboard\JobsHierarchy;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobHierarchyRequest extends FormRequest
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
        $rules = [
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            "parent_id"   => "nullable|exists:job_hierarchies,id",
            'added_by_id' => 'nullable|exists:users,id',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"]        = 'sometimes|string|max:255';
            $rules["$locale.position"]    = 'sometimes|string';
            $rules["$locale.description"] = 'sometimes|string';
        }
        return $rules;

    }
    protected function prepareForValidation(): void
    {
        $this->merge([
            "parent_id" => $this->parent_id == "" ? null : $this->parent_id,
        ]);
    }
}
