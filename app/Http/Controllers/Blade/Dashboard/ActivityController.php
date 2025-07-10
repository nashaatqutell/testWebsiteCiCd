<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function __construct() {}

    public function index()
    {
        $activities = Activity::all();

        return view('dashboard.activity.index', get_defined_vars());
    }
}
