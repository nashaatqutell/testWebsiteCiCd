<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Enums\User\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\User\StoreUserRequest;
use App\Http\Requests\Dashboard\User\UpdateUserRequest;
use App\Http\Resources\SimpleDataResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;

class UserController extends Controller
{

    protected $viewPath = 'dashboard.user.';
    private $routePath = 'admin.users';
//    public function __construct()
//    {
//        $this->middleware('permission:show_users')->only(['index','show']);
//        $this->middleware('permission:create_users')->only(['store']);
//        $this->middleware('permission:update_users')->only(['update']);
//        $this->middleware('permission:delete_users')->only(['destroy']);
//        $this->middleware('permission:active_users')->only(['changeStatus']);
//    }

    public function index()
    {
        $users = User::filter()->latest()->whereRole(RoleEnum::User->value)->paginate();
        return view($this->viewPath . 'index', get_defined_vars());
    }

    public function create()
    {
        $fields = ["name" => "text", 'email' => 'email', 'phone' => 'text', "password" => "password"];
        return view($this->viewPath . 'single', get_defined_vars());
    }


    public function store(StoreUserRequest $request)
    {
        User::query()->create($request->validated());
        return $this->webSuccessResponse(route: $this->routePath . '.index', message: __("messages.success"));
    }


    public function show(User $user)
    {
        return view($this->viewPath . 'single', get_defined_vars());
    }

    public function edit(User $user)
    {
        $fields = ["name" => "text", 'email' => 'email', 'phone' => 'text', "password" => "password"];

        return view($this->viewPath . 'single', get_defined_vars());
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return $this->webSuccessResponse(route: $this->routePath . '.index', message: __("messages.update"));
    }


    public function destroy(User $user)
    {
        try {
            $user->delete();
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

    public function changeStatus(User $user)
    {
        $user->toggleActivation();
        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated'),
        ]);
    }
}
