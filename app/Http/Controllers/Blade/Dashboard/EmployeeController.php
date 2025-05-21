<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Employee\StoreEmployeeRequest;
use App\Http\Requests\Dashboard\Employee\UpdateEmployeeRequest;
use App\Models\User;
use App\Service\EmployeeService;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{

    private string $viewPath = 'dashboard.employees.';

    private string $routePath = "admin.employees";

    public function __construct(protected EmployeeService $employeeService = new EmployeeService())
    {
        $this->middleware('permission:show_employees')->only(['index','show']);
        $this->middleware('permission:create_employees')->only(['store']);
        $this->middleware('permission:update_employees')->only(['update']);
        $this->middleware('permission:delete_employees')->only(['destroy']);
        $this->middleware('permission:active_employees')->only(['changeStatus']);
    }

    public function index()
    {
        $employees = $this->employeeService->index('get');

        return view($this->viewPath . 'index', get_defined_vars());
    }

    public function create()
    {
        $fields = ["name" => "text", 'email' => 'email', 'phone' => 'text', "password" => "password"];
        $roles = Role::query()->get();
        return view($this->viewPath . 'single', get_defined_vars());
    }


    public function store(StoreEmployeeRequest $request)
    {
        $employee = $this->employeeService->store($request);
        $role = Role::findById($request->role_id, 'web');
        $employee->assignRole($role);
        return $this->webSuccessResponse(route: $this->routePath . '.index', message: __("messages.success"));
    }


    public function show(User $employee)
    {
        return view($this->viewPath . 'single', get_defined_vars());
    }


    public function edit(User $employee)
    {
        $fields = ["name" => "text", 'email' => 'email', 'phone' => 'text', "password" => "password"];
        $roles = Role::query()->get();

        return view($this->viewPath . 'single', get_defined_vars());
    }


    public function update(UpdateEmployeeRequest $request, User $employee)
    {
        $employee = $this->employeeService->update($request, $employee);

        if ($request->role_id)
        {
            $role = Role::findById($request->role_id, 'web');
            $employee->syncRoles([$role]);
        }

        return $this->webSuccessResponse(route: $this->routePath . '.index', message: __("messages.update"));
    }


    public function destroy(User $employee)
    {
        try {
            $this->employeeService->destroy($employee);
            return response()->json([
                'success' => true,
                'message' => __('keys.deleted')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong')
            ], 500);
        }
    }

    public function changeStatus(User $employee)
    {
        $this->employeeService->changeStatus($employee);

        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated'),
        ]);
    }
}
