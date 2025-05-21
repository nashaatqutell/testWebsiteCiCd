<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Models\Contact\Contact;
use App\Service\ContactService;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->middleware('permission:show_contacts')->only(['index', 'show']);
        $this->middleware('permission:create_contacts')->only(['store']);
        $this->middleware('permission:update_contacts')->only(['update']);
        $this->middleware('permission:delete_contacts')->only(['destroy']);
        $this->middleware('permission:active_contacts')->only(['changeStatus']);

        $this->contactService = $contactService;
    }

    public function index()
    {
        $contacts = $this->contactService->getAllContacts('paginate');
        return $this->paginateResponse(ContactResource::collection($contacts), $contacts);
    }

    public function show(Contact $contact)
    {
        return $this->successResponse(data: ContactResource::make($this->contactService->getContactById($contact)));
    }

    public function destroy(Contact $contact)
    {
        $this->contactService->deleteContact($contact);
        return $this->successResponse(message: __('messages.delete'));
    }

    #=================change status from new to replied=================#
    public function changeStatus(Contact $contact)
    {
        $this->contactService->toggleContactStatus($contact);
        return $this->successResponse(message: __('messages.update'));
    }
}
