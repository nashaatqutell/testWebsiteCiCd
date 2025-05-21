<?php

namespace App\Service;

use App\Models\Contact\Contact;

class ContactService
{
    public function getAllContacts($query)
    {
        $contactsQuery = Contact::query()->latest();
        return $query === 'paginate' ? $contactsQuery->paginate(10) : $contactsQuery->get();
    }

    public function getContactById(Contact $contact)
    {
        return $contact;
    }

    public function deleteContact(Contact $contact)
    {
        $contact->delete();
    }

    public function toggleContactStatus(Contact $contact)
    {
        $contact->update(['status' => !$contact->status]);
    }
}
