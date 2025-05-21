<?php

namespace App\Exports;

use App\Models\Contact\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContactsExport implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Contact::select('id', 'name', 'email', 'phone', 'message', 'subject')->latest()->get();
    }
    public function headings(): array
    {
        return ["ID", "Name", "Email", "Phone", "Message", "Subject"];
    }
}
