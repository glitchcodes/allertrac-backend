<?php

namespace App\Actions\User;

use App\Actions\OTP\GenerateOTP;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;

readonly class CreateResetPasswordTicket
{
    public function __construct(
        private GenerateOTP $otpGenerator
    ) {}

    /**
     * @param string $email
     * @throws ModelNotFoundException
     * @return array
     */
    public function execute(string $email): array
    {
        // Get user id
        $user = User::where('email', $email)->firstOrFail();

        // Generate a 4-digit OTP
        $otp = $this->otpGenerator->execute('forget-password', $user->id);

        // Send the OTP to the user's inbox
        Mail::to($email)->queue(new ResetPassword($otp['code']));

        // Add OTP identifier to the response
        // It must be encoded in base64
        return [
            'identifier' => base64_encode($otp['identifier'])
        ];
    }
}
