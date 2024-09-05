<?php

namespace App\Actions\OTP;

use App\Mail\OTPVerification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

/**
 * Resend OTP to the user's email
 *
 * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
 */
readonly class ResendOTP
{
    public function __construct(
        private GenerateOTP $otpGenerator
    ) {}

    public function execute($identifier): void
    {
        $userId = explode(':', $identifier)[2];
        $otp = $this->otpGenerator->execute($userId);

        $user = User::findOrFail($userId);
        Mail::to($user->email)->queue(new OTPVerification($otp['code']));
    }
}
