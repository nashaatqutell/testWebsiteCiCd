<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Enums\User\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Employee\StoreEmployeeRequest;
use App\Http\Requests\Dashboard\Employee\UpdateEmployeeRequest;
use App\Http\Resources\SimpleDataResource;
use App\Http\Resources\UserResource;
use App\Models\User;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_employees')->only(['index','show']);
        $this->middleware('permission:create_employees')->only(['store']);
        $this->middleware('permission:update_employees')->only(['update']);
        $this->middleware('permission:delete_employees')->only(['destroy']);
        $this->middleware('permission:active_employees')->only(['changeStatus']);
    }

    public function index()
    {
        $employees = User::filter()->latest()->whereRole(RoleEnum::Employee->value)->paginate();
        return $this->paginateResponse(
            data: UserResource::collection($employees),
            collection: $employees
        );
    }

    public function list()
    {
        $employees = User::query()->latest()->whereRole(RoleEnum::Employee->value)->get();
        return $this->successResponse(data: SimpleDataResource::collection($employees),message: __("messages.fetched_successfully"));
    }

    public function store(StoreEmployeeRequest $request)
    {
        $employee = User::query()->create($request->validated());
        return $this->successResponse(data: $employee->getResource(), message: __("messages.success"));
    }

    public function show(User $employee)
    {
        return $this->successResponse(data: UserResource::make($employee),message: __("messages.fetched_successfully"));
    }

    public function update(UpdateEmployeeRequest $request, User $employee)
    {
        $employee->update($request->validated());
        return $this->successResponse(data: $employee->getResource(), message: __("messages.update"));
    }

    public function destroy(User $employee)
    {
        $employee->delete();
        return $this->successResponse(message: __("messages.delete"));
    }

    public function changeStatus(User $employee)
    {
        $employee->toggleActivation();
        return $this->successResponse(message: __("messages.update"));
    }


}
