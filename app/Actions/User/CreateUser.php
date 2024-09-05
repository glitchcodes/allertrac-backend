<?php

namespace App\Actions\User;

use App\Actions\OTP\GenerateOTP;
use App\Mail\OTPVerification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

readonly class CreateUser
{
    public function __construct(
        private GenerateOTP $otpGenerator
    ) {}

    public function execute(array $credentials, $isOAuth): array
    {
        // Create a new user on the database with email and password only
        $user = User::create($credentials);

        // Response to be returned
        $response = [
            'user' => $user,
            'redirect_to' => $isOAuth ? 'onboarding' : 'verification',
            'message' => 'Registration successful.'
        ];

        // If registering with email/password
        // Generate a 4-digit OTP and send it to the user's inbox
        if (!$isOAuth) {
            // Generate a 4-digit OTP

            $otp = $this->otpGenerator->execute($user->id);

            Mail::to($credentials['email'])->queue(new OTPVerification($otp['code']));

            // Add OTP identifier to the response
            // It must be encoded in base64
            $response['identifier'] = base64_encode($otp['identifier']);
        } else {
            $response['token'] = $user->createToken('api-token')->plainTextToken;
        }

        return $response;
    }
}
