<?php

namespace App\Actions\User;

use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class LoginOAuthUser
{
    use ApiResponseTrait;

    public function __construct(
        private CreateUser $createUser
    ) {}

    public function execute(array $credentials): JsonResponse
    {
        $user = User::where('email', '=', $credentials['email'])->first();

        if (!$user) {
            // Verify the email immediately
            $credentials['email_verified_at'] = now();
            // Create the user
            $response = $this->createUser->execute($credentials, true);

            return $this->sendResponse($response);
        } else {
            // TODO: Check if the user has linked their Google account first to prevent impersonation
            $token = $user->createToken('api-token')->plainTextToken;

            return $this->sendResponse([
                'user' => $user,
                'token' => $token
            ]);
        }
    }
}
