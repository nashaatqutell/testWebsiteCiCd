<?php

namespace App\Service;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login($request): object
    {
        $data = $request->validated();
        $user = User::query()->where("email", $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => __("auth.Invalid email or password"),
            ]);
        }
        $device = $request->userAgent(); // Get the device name
        $expiresAt = Carbon::now()->addDays(7); // Token expires in 7 days
        $token = $user->createToken($device, ['app:all'], $expiresAt)->plainTextToken;
        $user->token = $token;
        return $user;
    }

    public function logout($user): void
    {
        $user->currentAccessToken()->delete();
    }
}
