<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Service\AuthService;
use App\Traits\ApiResponse;

class AuthController extends Controller
{

    use ApiResponse;

    protected AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login(LoginRequest $request)
    {
        try {
            $auth = $this->authService->login($request);
            return $this->successResponse(data: UserResource::make($auth), message: __("auth.Login_successfully"));
        } catch (\Exception $e) {
            return $this->errorResponse(message: $e->getMessage());
        }
    }

    public function logout()
    {
        $auth = auth()->user();
        $this->authService->logout($auth);
        return $this->successResponse(message: __("auth.Logout_successfully"));
    }

}
