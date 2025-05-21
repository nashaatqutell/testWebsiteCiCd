<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Roles\AssignRoleRequest;
use App\Http\Requests\Dashboard\Roles\StoreRoleRequest;
use App\Http\Requests\Dashboard\Roles\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\User;
use App\Service\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{


    public function __construct(protected RoleService $roleService = new RoleService())
    {
        $this->middleware('permission:show_roles')->only(['index', 'show']);
        $this->middleware('permission:create_roles')->only(['store']);
        $this->middleware('permission:update_roles')->only(['update']);
        $this->middleware('permission:delete_roles')->only(['destroy']);
        $this->middleware('permission:active_roles')->only(['changeStatus']);
    }

    public function index()
    {
        $roles = $this->roleService->index('paginate');
        return $this->paginateResponse(data: RoleResource::collection($roles), collection: $roles);
    }

    public function list(): JsonResponse
    {
        $roles = $this->roleService->list();
        $message = __("roles.Roles fetched successfully");
        return $this->successResponse(data: RoleResource::collection($roles), message: $message);
    }


    public function store(StoreRoleRequest $request): JsonResponse
    {
        $role = $this->roleService->store($request);
        return $this->successResponse(data: RoleResource::make($role), message: __("messages.success"));
    }

    public function update(UpdateRoleRequest $request, Role $role): JsonResponse
    {
        $role = $this->roleService->update($request, $role);
        return $this->successResponse(data: RoleResource::make($role), message: __("messages.success"));
    }

    public function show(Role $role): JsonResponse
    {
        return $this->successResponse(data: RoleResource::make($role));
    }

    public function destroy(Role $role): JsonResponse
    {
        $this->roleService->destroy($role);
        return $this->successResponse(message: __("messages.delete"));
    }

    public function assignRoleToUser(AssignRoleRequest $request)
    {
        $data = $request->validated();
        $user = User::query()->whereId($data['user_id'])->first();
        $role = Role::findById($data['role_id'], 'api');
        $user->assignRole($role); // add many of role to user
//        $user->syncRoles([$role]);
        return $this->successResponse(message: __("messages.success"));
    }
}
