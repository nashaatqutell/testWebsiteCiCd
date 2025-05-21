<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Exports\ContactsExport;
use App\Exports\EmployeesExport;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcelController extends Controller
{
    public function exportUsers()
    {
        $fileName = 'users.xlsx';
        Excel::store(new UsersExport, $fileName, 'public');
        $downloadUrl = URL::to('/storage/' . $fileName);
        return response()->json(['download_url' => $downloadUrl]);
    }
    public function exportEmployees()
    {
        $fileName = 'employees.xlsx';
        Excel::store(new EmployeesExport, $fileName, 'public');
        $downloadUrl = URL::to('/storage/' . $fileName);
        return response()->json(['download_url' => $downloadUrl]);
    }

    public function exportContacts()
    {
        $fileName = 'contacts.xlsx';
        Excel::store(new ContactsExport, $fileName, 'public');
        $downloadUrl = URL::to('/storage/' . $fileName);
        return response()->json(['download_url' => $downloadUrl]);
    }
}
