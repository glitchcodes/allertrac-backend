<?php

namespace App\Actions\User;

use App\Enums\HttpCodes;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LinkAccount
{
    use ApiResponseTrait;

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

        $user = Auth::user();

        try {
            DB::beginTransaction();

            // Check if the account is already linked
            $account = $user->connectedAccounts()
                ->where('provider_id', '=', $credentials['account_id'])
                ->where('provider', '=', $credentials['provider'])
                ->first();

            if ($account) {
                return $this->sendErrorResponse(
                    'Account is already linked.',
                    HttpCodes::CONFLICT->value,
                    null,
                    HttpCodes::CONFLICT->getHttpStatusCode()
                );
            }

            // Link the account to the user
            $user->connectedAccounts()->create([
                'provider' => $credentials['provider'],
                'provider_id' => $credentials['account_id']
            ]);

            DB::commit();

            return $this->sendResponse([
                'accounts' => $user->connectedAccounts,
                'message' => 'Account linked successfully.'
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return $this->sendErrorResponse(
                'Failed to link account.',
                HttpCodes::INTERNAL_SERVER_ERROR->value,
                null,
                HttpCodes::INTERNAL_SERVER_ERROR->getHttpStatusCode()
            );
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
