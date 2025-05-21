<?php

namespace App\Service;

use App\Http\Requests\Dashboard\Blogs\StoreBlogRequest;
use App\Http\Requests\Dashboard\Blogs\UpdateBlogRequest;
use App\Http\Requests\Dashboard\Roles\StoreRoleRequest;
use App\Http\Requests\Dashboard\Roles\UpdateRoleRequest;
use App\Models\Blog\Blog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function index($query)
    {
        $roleQuery = Role::query()->latest();
        return $query === 'paginate' ? $roleQuery->paginate(10) : $roleQuery->get();
    }

    public function list(): Collection
    {
        return Role::query()->latest()->get();
    }

    public function show(Role $role): Role
    {
        return $role;
    }

    public function store(StoreRoleRequest $request): Role
    {
        DB::beginTransaction();
        $data = $request->validated();
        $role = Role::create(['name' => $data['name'], 'guard_name' => 'web']);
        $permissions = Permission::query()->whereIn('id', $data['permission'])->get();
        $role->syncPermissions($permissions); // Assign permission to role but must the permission list of names not ids
        DB::commit();
        return $role;
    }

    public function update(UpdateRoleRequest $request, Role $role): Role
    {
        DB::beginTransaction();
        $data = $request->validated();
        $role->update(["name" => $data['name']]);
        $permissions = Permission::query()->whereIn('id', $data['permission'])->get();
        $role->syncPermissions($permissions);
        DB::commit();
        return $role;
    }

    public function destroy(Role $role): void
    {
        $role->delete();
    }

    public function fetchPermissionTypes(): array
    {
        $types = Permission::query()->pluck("type")->unique();
        $result = [];

        foreach ($types as $type) {
            $result[$type] = Permission::query()->where("type", $type)->get()->map(function ($permission) {
                $parts = explode('_', $permission->name); // create_users => ["create", "users"]
                $action = __("permission.actions.{$parts[0]}");
                $model = __("permission.models.{$parts[1]}");
                return [
                    'id' => $permission->id,
                    'name' => "{$action} {$model}",
                    "type" => $permission->type
                ];
            });
        }
        return $result;
    }

}
