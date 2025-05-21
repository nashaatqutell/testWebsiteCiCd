<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Enums\About\TypeEnum;
use App\Enums\User\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Contact\Contact;
use App\Models\Service\Service;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;


class DashboardController extends Controller
{

    public function index()
    {
        $servicesCount = Service::whereIsActive()
            ->whereNull('parent_id')->count();
        $contactsCount = Contact::count();
        $employeesCount = User::whereRole(RoleEnum::Employee->value)->count();
        $activities = Activity::latest()->take(10)->get();
        return view('dashboard.index', get_defined_vars());
    }
}
