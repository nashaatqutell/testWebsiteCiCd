<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contact\Contact;
use App\Models\User;

class StatisticsController extends Controller
{
    public function getStatistics()
    {
        $usersCount  = User::where('role', 2)->count();
        $employeesCount = User::where('role', 3)->count();
        $contactUsNew = Contact::where('status',1)->count();
        $contactUsReplied = Contact::where('status',0)->count();

        $data = [
            'users_Count' => $usersCount,
            'employees_Count' => $employeesCount,
            'contact_New_Count' => $contactUsNew,
            'contact_replied_Count' => $contactUsReplied,
        ];

        return $this->successResponse($data);
    }
}
