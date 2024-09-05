<?php

namespace App\Actions\User;

use App\Enums\HttpCodes;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

readonly class LoginUser
{
    use ApiResponseTrait;

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
            return $this->sendErrorResponse(
                'Your email is not verified',
                HttpCodes::FORBIDDEN->value,
                null,
                HttpCodes::FORBIDDEN->getHttpStatusCode()
            );
        }

        // Redirect to welcome screen if user has not completed onboarding
        $needsOnboarding = false;

        if ($user->first_name === null || $user->last_name === null) {
            $needsOnboarding = true;
        }

        // Generate token for the user
        $token = $user->createToken('api-token')->plainTextToken;

        return $this->sendResponse([
            'user' => $user,
            'token' => $token,
            'redirect_to' => $needsOnboarding ? 'onboarding' : 'home'
        ], HttpCodes::OK->getHttpStatusCode());
    }
}
