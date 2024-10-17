<?php

namespace App\Actions\User;

use App\Enums\HttpCodes;
use App\Models\ConnectedAccount;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class LoginOAuthUser
{
    use ApiResponseTrait;

    public function __construct(
        private CreateUser $createUser
    ) {}

    public function execute(array $credentials): JsonResponse
    {
        // Validate ID token with the OAuth provider
        if (!$this->validateIdToken($credentials['id_token'], $credentials['provider'], $credentials['device_type'])) {
            return $this->sendErrorResponse(
                'Invalid ID token.',
                HttpCodes::UNAUTHORIZED->value,
                null,
                HttpCodes::UNAUTHORIZED->getHttpStatusCode()
            );
        }

        $account = ConnectedAccount::where('provider_id', '=', $credentials['account_id'])
            ->where('provider', '=', $credentials['provider'])
            ->first();

        // If account exists then login the user
        if ($account) {
            $token = $account->user->createToken('api-token')->plainTextToken;

            return $this->sendResponse([
                'user' => $account->user,
                'token' => $token
            ]);
        } else {
            // Check if the email already exists on the database
            $emailExists = User::where('email', '=', $credentials['email'])->exists();

            if ($emailExists) {
                return $this->sendErrorResponse(
                    'An account with this email already exists. You will need to link it to your account first.',
                    HttpCodes::CONFLICT->value,
                    null,
                    HttpCodes::CONFLICT->getHttpStatusCode()
                );
            }

            // Create the user
            try {
                DB::beginTransaction();

                $response = $this->createUser->execute([
                    'email' => $credentials['email'],
                    'first_name' => $credentials['first_name'],
                    'last_name' => $credentials['last_name'],
                    'email_verified_at' => now()
                ], true);

                ConnectedAccount::create([
                    'provider' => $credentials['provider'],
                    'provider_id' => $credentials['account_id'],
                    'user_id' => $response['user']->id
                ]);

                DB::commit();

                return $this->sendResponse($response);
            } catch (\Throwable $e) {
                DB::rollBack();

                return $this->sendErrorResponse(
                    'An error occurred while creating your account. Please try again later.',
                    HttpCodes::INTERNAL_SERVER_ERROR->value,
                    null,
                    HttpCodes::INTERNAL_SERVER_ERROR->getHttpStatusCode()
                );
            }
        }
    }

    private function validateIdToken(string $idToken, string $provider, string $deviceType): bool
    {
        // Validate the ID token with the OAuth provider
        if ($provider == 'google') {
            // Token must be validated with their respective client IDs
            $clientId = match ($deviceType) {
                // 'android' => config('oauth.providers.google.android.client_id'),
                'ios' => config('oauth.providers.google.ios.client_id'),
                default => config('oauth.providers.google.web.client_id'), // CapGo/Social Login supports web client id for android
            };

            $client = new \Google_Client([
                'client_id' => $clientId
            ]);

            $payload = $client->verifyIdToken($idToken);

            if (!$payload) {
                return false;
            }

            return true;
        } else {
            // Implement validation for other providers
            return false;
        }
    }
}
