<?php

namespace App\Service;

use App\Enums\User\RoleEnum;
use App\Http\Requests\Dashboard\Employee\StoreEmployeeRequest;
use App\Http\Requests\Dashboard\Employee\UpdateEmployeeRequest;
use App\Models\User;

class EmployeeService
{
    public function index($query)
    {
        $employeeQuery =User::filter()->latest()->whereRole(RoleEnum::Employee->value);
        return   $query === 'paginate' ? $employeeQuery->paginate(10) : $employeeQuery->get();
    }

    public function list():\Illuminate\Database\Eloquent\Collection
    {
        return User::query()->latest()->whereRole(RoleEnum::Employee->value)->get();
    }

    public function show(User $employee) : User
    {
        return $employee;
    }

    public function store(StoreEmployeeRequest $request) : User
    {
        return User::query()->create($request->validated());
    }

    public function update(UpdateEmployeeRequest $request, User $employee) : User
    {
        $employee->update($request->validated());
        return $employee;
    }

    public function destroy(User $employee) : void
    {
        $employee->delete();
    }

    public function changeStatus(User $employee) : User
    {
        $employee->toggleActivation();
        return $employee;
    }

}
