<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Roles\StoreRoleRequest;
use App\Http\Requests\Dashboard\Roles\UpdateRoleRequest;
use App\Service\RoleService;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    private string $routePath = "admin.roles";
    private string $viewPath = "dashboard.roles.";

    public function __construct(protected RoleService $roleService = new RoleService())
    {
        $this->middleware('permission:show_roles')->only(['index','show']);
        $this->middleware('permission:create_roles')->only(['store']);
        $this->middleware('permission:update_roles')->only(['update']);
        $this->middleware('permission:delete_roles')->only(['destroy']);
        $this->middleware('permission:active_roles')->only(['changeStatus']);
    }

    public function index()
    {
        $roles = $this->roleService->index('get');
        return view($this->viewPath . 'index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = $this->roleService->fetchPermissionTypes();
        return view($this->viewPath . 'single',get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $role = $this->roleService->store($request);

        return $this->webSuccessResponse(route: $this->routePath . '.index', message: __("messages.success"));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = $this->roleService->fetchPermissionTypes();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role->id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view($this->viewPath . 'single', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role = $this->roleService->update($request, $role);

        return $this->webSuccessResponse(route: $this->routePath . '.index', message: __("messages.update"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            $this->roleService->destroy($role);
            return response()->json([
                'success' => true,
                'message' => __("keys.deleted")
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong')
            ], 500);
        }
    }
}
