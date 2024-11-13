<?php

namespace App\Actions\OTP;

use App\Mail\ConfirmAccount;
use App\Mail\ResetPassword;
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
        $type = explode(':', $identifier)[1];
        $userId = explode(':', $identifier)[2];
        $otp = $this->otpGenerator->execute($type, $userId);

        // Only used to check whether the passed user ID exists
        $user = User::findOrFail($userId);

        if ($type === 'email-verification') {
            Mail::to($user->email)->queue(new ConfirmAccount($otp['code']));
        } else if ('forget-password') {
            Mail::to($user->email)->queue(new ResetPassword($otp['code']));
        }
    }
}
