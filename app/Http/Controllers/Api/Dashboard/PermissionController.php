<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Service\RoleService;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{



    public function fetchAllPermissions()
    {
        // fetch all permissions in the system
        $permissions = Permission::query()->latest()->get();
        return $this->successResponse(
            PermissionResource::collection($permissions),
            message: __(
            "messages.fetched_successfully"
        )
        );
    }

    public function fetchPermissionForUser()
    {
        // fetch all permissions in the system for auth user
        $user = auth()->user();
        $roles = $user->roles()->get();
        $permissions = [];

        foreach ($roles as $role) {
            $permissions = array_merge($permissions, $role->permissions->pluck('name')->toArray());
        }
        return $permissions;
    }


    public function fetchPermissionForRole(Role $role)
    {
        $permissions = $role->permissions ?? [];
        return $this->successResponse(
            PermissionResource::collection($permissions),
            message: __(
            "messages.fetched_successfully"
        )
        );
    }

    public function fetchPermissionTypes()
    {
      $result = (new RoleService())->fetchPermissionTypes();
        return $this->successResponse(data: $result, message: __("messages.fetched_successfully"));
    }
}
