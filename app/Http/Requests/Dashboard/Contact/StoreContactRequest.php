<?php

namespace App\Http\Requests\Dashboard\Contact;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string',
            'service_id' => 'nullable|exists:services,id',
        ];
    }
}
