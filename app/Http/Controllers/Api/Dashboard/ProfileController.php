<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Auth\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_profiles')->only(['show']);
        $this->middleware('permission:update_profiles')->only(['update']);
    }
    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        $user->update($request->validated());
        return $this->successResponse(data: $user->getResource(), message: __("messages.update"));
    }

    public function show()
    {
        return $this->successResponse(data: auth()->user()->getResource(),message: __("messages.fetched_successfully"));
    }
}
