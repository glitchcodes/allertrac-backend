<?php

namespace App\Actions\User;

use App\Enums\HttpCodes;
use App\Models\ConnectedAccount;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Client\ConnectionException;
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
        try {
            $provider_id = validateOAuthProvider($credentials['provider'], $credentials)['provider_id'];
        } catch (ConnectionException $e) {
            return $this->sendErrorResponse(
                $e->getMessage(),
                HttpCodes::SERVER_ERROR->value,
                null,
                HttpCodes::SERVER_ERROR->getHttpStatusCode()
            );
        } catch (\Exception $e) {
            return $this->sendErrorResponse(
                $e->getMessage(),
                HttpCodes::FORBIDDEN->value,
                null,
                HttpCodes::FORBIDDEN->getHttpStatusCode()
            );
        }

        $account = ConnectedAccount::where('provider_id', '=', $provider_id)
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
                    'An account with this provider already exists. You will need to link it to your account first.',
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
                    'provider_id' => $provider_id,
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
}
