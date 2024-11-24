<?php

namespace App\Actions\User;

use App\Actions\OTP\GenerateOTP;
use App\Enums\HttpCodes;
use App\Mail\ConfirmAccount;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

readonly class LoginUser
{
    use ApiResponseTrait;

    public function __construct(
        private GenerateOTP $otpGenerator
    ) {}

    public function execute(array $credentials): JsonResponse
    {
        if (!Auth::attempt($credentials)) {
            return $this->sendErrorResponse(
                'Incorrect credentials.',
                HttpCodes::INVALID_CREDENTIALS->value,
                null,
                HttpCodes::INVALID_CREDENTIALS->getHttpStatusCode()
            );
        }

        $user = Auth::user();

        // If the credentials are correct, check if the user's email is verified
        if (!$user->isEmailVerified()) {
            // Generate OTP and send it to the user's inbox
            $otp = $this->otpGenerator->execute('email-verification', $user->id);

            Mail::to($credentials['email'])->queue(new ConfirmAccount($otp['code']));

            return $this->sendErrorResponse(
                'Your email is not verified',
                HttpCodes::ACCESS_DENIED->value,
                null,
                HttpCodes::ACCESS_DENIED->getHttpStatusCode(),
                [
                    'identifier' => base64_encode($otp['identifier'])
                ]
            );
        }

        // Redirect to welcome screen if user has not completed onboarding
        $needsOnboarding = false;

        if ($user->first_name === null || $user->last_name === null) {
            $needsOnboarding = true;
        }

        // Generate token for the user
        $token = $user->createToken(
            'api-token',
            ['*'],
            now()->addDays(90)
        )->plainTextToken;

        return $this->sendResponse([
            'user' => $user,
            'token' => $token,
            'redirect_to' => $needsOnboarding ? 'onboarding' : 'home'
        ], HttpCodes::OK->getHttpStatusCode());
    }
}
