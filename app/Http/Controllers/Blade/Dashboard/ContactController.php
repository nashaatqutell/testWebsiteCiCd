<?php

namespace App\Http\Controllers\Blade\Dashboard;

use Illuminate\Http\Request;
use App\Models\Contact\Contact;
use App\Service\ContactService;
use App\Http\Controllers\Controller;
use Exception;

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
        $contacts = $this->contactService->getAllContacts('get');
        return view('dashboard.contact.index', get_defined_vars());
    }


    public function destroy(Contact $contact)
    {
        $this->contactService->deleteContact($contact);
        try {
            $this->contactService->deleteContact($contact);
            return response()->json([
                'success' => true,
                'message' => __('contact.contact_deleted_successfully')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong')
            ], 500);
        }
    }

    #=================change status from new to replied=================#
    public function changeStatus(Contact $contact)
    {
        $this->contactService->toggleContactStatus($contact);
        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated')
        ]);
    }
}
