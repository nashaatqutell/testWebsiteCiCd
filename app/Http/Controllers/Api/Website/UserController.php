<?php

namespace App\Http\Controllers\Api\Website;

use App\Enums\User\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $users = User::query()->latest()->whereIsActive()->whereRole(RoleEnum::User->value)->get();
        return $this->successResponse(data: UserResource::collection($users),message: __("messages.fetched_successfully"));
    }
}
