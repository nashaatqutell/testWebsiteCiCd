<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Auth\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:show_profiles')->only(['show']);
        $this->middleware('permission:update_profiles')->only(['update']);
    }

    public function edit()
    {
        return view('dashboard.profile.edit', [
            'profile' => auth()->user()
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();

        $data = $request->validated();

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('image')) {
            $user->clearMediaCollection('profile_images');
            $user->addMedia($request->file('image'))->toMediaCollection('profile_images');
        }
        $user->update($data);

        return to_route('admin.profile.edit')->with([
            "message" => __("messages.update"),
            "alert-type" => "success"
        ]);
    }
    public function show (User $user)
    {
        return view('dashboard.profile.show',get_defined_vars());
    }
}
