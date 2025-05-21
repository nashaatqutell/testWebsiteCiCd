<?php

namespace App\Http\Controllers\Api\Website;

use App\Enums\User\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;

class EmployeeController extends Controller
{
    public function __invoke()
    {
        $employees = User::query()->latest()->whereIsActive()->whereRole(RoleEnum::Employee->value)->get();
        return $this->successResponse(data: UserResource::collection($employees),message: __("messages.fetched_successfully"));
    }
}
