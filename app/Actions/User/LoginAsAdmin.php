<?php

namespace App\Actions\User;

use App\Enums\HttpCodes;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

readonly class LoginAsAdmin
{
    use ApiResponseTrait;

    public function execute(array $credentials): JsonResponse
    {
        // Attempt to authenticate admin user
        if (!Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'is_admin' => true
        ])) {
            return $this->sendErrorResponse(
                'Incorrect credentials.',
                HttpCodes::INVALID_CREDENTIALS->value,
                null,
                HttpCodes::INVALID_CREDENTIALS->getHttpStatusCode()
            );
        }

        $user = Auth::user();

        // Generate token for the user
        $token = $user->createToken('api-token')->plainTextToken;

        return $this->sendResponse([
            'token' => $token
        ], HttpCodes::OK->getHttpStatusCode());
    }
}
