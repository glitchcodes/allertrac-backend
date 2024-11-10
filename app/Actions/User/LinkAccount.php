<?php

namespace App\Actions\User;

use App\Enums\HttpCodes;
use App\Models\ConnectedAccount;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class LinkAccount
{
    use ApiResponseTrait;

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
        } catch (Exception $e) {
            return $this->sendErrorResponse(
                $e->getMessage(),
                HttpCodes::FORBIDDEN->value,
                null,
                HttpCodes::FORBIDDEN->getHttpStatusCode()
            );
        }

        $user = Auth::user();

        try {
            DB::beginTransaction();

            // Check if the account is already linked
            $account_exists = ConnectedAccount::where('provider_id', '=', $provider_id)
                ->where('provider', '=', $credentials['provider'])
                ->exists();

            if ($account_exists) {
                return $this->sendErrorResponse(
                    'Account is already linked to another account.',
                    HttpCodes::CONFLICT->value,
                    null,
                    HttpCodes::CONFLICT->getHttpStatusCode()
                );
            }

            // Link the account to the user
            $user->connectedAccounts()->create([
                'provider' => $credentials['provider'],
                'provider_id' => $provider_id
            ]);

            DB::commit();

            return $this->sendResponse([
                'accounts' => $user->connectedAccounts,
                'message' => 'Account linked successfully.'
            ]);
        } catch (Throwable $e) {
            DB::rollBack();

            return $this->sendErrorResponse(
                'Failed to link account.',
                HttpCodes::INTERNAL_SERVER_ERROR->value,
                null,
                HttpCodes::INTERNAL_SERVER_ERROR->getHttpStatusCode()
            );
        }
    }
}
