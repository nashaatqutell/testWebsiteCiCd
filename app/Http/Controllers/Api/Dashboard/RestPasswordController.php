<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ResetPassword\OtpRequest;
use App\Http\Requests\Dashboard\ResetPassword\RestPasswordRequest;
use App\Mail\OtpMail;
use App\Mail\sendOtp;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RestPasswordController extends Controller
{
    public function sendOtp(OtpRequest $request)
    {
        return $this->generateAndSendOtp($request->validated());
    }

    public function checkOtp(OtpRequest $request)
    {
        $user = $this->getUserByEmail($request->validated()['email']);
        if (!$user) {
            return $this->errorResponse(message: __("messages.not_found"));
        }

        if ($user->code !== $request->validated()['code']) {
            return $this->errorResponse(message: __("messages.code_not_match"));
        }

        $user->update(['code' => null, 'expire_code' => now()]);
        return $this->successResponse(message: __("messages.success"));
    }

    public function resetPassword(RestPasswordRequest $request)
    {
        $data = $request->validated();
        $user = $this->getUserByEmail($data['email']);

        if (!$user) {
            return $this->errorResponse(message: __("messages.not_found"));
        }

        if (Hash::check($data['password'], $user->password)) {
            return $this->errorResponse(message: __("messages.new_password_must_be_different_from_old_password"));
        }

        $user->update(['password' => Hash::make($data['password'])]);
        return $this->successResponse(message: __("messages.success"));
    }

    public function resendOtp(OtpRequest $request)
    {
        return $this->generateAndSendOtp($request->validated());
    }



    ///// this private function for send otp and resend otp
    private function generateAndSendOtp(array $validatedData)
    {
        $user = $this->getUserByEmail($validatedData['email']);
        if (!$user) {
            return $this->errorResponse(message: __("messages.not_found"));
        }

        $code = generate_unique_code(User::class, length: 6, letter_type: 'numbers');
        $user->update(['code' => $code]);


        // Send OTP via email
        Mail::to($user->email)->send(new OtpMail($code, $user->email));

        return $this->successResponse(message: __("messages.the otp code has been sent successfully"));
//        return $this->successResponse(data: ['code' => $code], message: __("messages.success"));
    }

    private function getUserByEmail(string $email): ?User
    {
        return User::query()->whereEmail($email)->first();
    }
}
