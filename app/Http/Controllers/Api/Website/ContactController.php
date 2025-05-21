<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Contact\StoreContactRequest;
use App\Models\Contact\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ContactController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreContactRequest $request)
    {
        $user = User::updateOrCreate(
            ['email' => $request->email, 'phone' => $request->phone],
            [
                'name' => $request->name,
                'password' => Hash::make('default_password'),
            ]
        );

        $contact = Contact::create($request->validated());

        return $this->successResponse(data: $contact->getResource(), message: __('messages.success'));
    }
}
