<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Enums\User\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\User\StoreUserRequest;
use App\Http\Requests\Dashboard\User\UpdateUserRequest;
use App\Http\Resources\SimpleDataResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_users')->only(['index','show']);
        $this->middleware('permission:create_users')->only(['store']);
        $this->middleware('permission:update_users')->only(['update']);
        $this->middleware('permission:delete_users')->only(['destroy']);
        $this->middleware('permission:active_users')->only(['changeStatus']);
    }

    public function index()
    {
        $users = User::filter()->latest()->whereRole(RoleEnum::User->value)->paginate();
        return $this->paginateResponse(
            data: UserResource::collection($users),
            collection: $users
        );
    }

    public function list()
    {
        $users = User::query()->latest()->whereRole(RoleEnum::User->value)->get();
        return $this->successResponse(data: SimpleDataResource::collection($users),message: __("messages.fetched_successfully"));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::query()->create($request->validated());
        return $this->successResponse(data: $user->getResource(), message: __("messages.success"));
    }


    public function show(User $user)
    {
        return $this->successResponse(data: UserResource::make($user),message: __("messages.fetched_successfully"));
    }


    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return $this->successResponse(data: $user->getResource(), message: __("messages.update"));
    }


    public function destroy(User $user)
    {
        $user->delete();
        return $this->successResponse(message: __("messages.delete"));
    }

    public function changeStatus(User $user)
    {
        $user->toggleActivation();
        return $this->successResponse(message: __("messages.update"));
    }
}
