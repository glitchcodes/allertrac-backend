<?php

namespace App\Http\Controllers;

use App\Actions\User\LinkAccount;
use App\Actions\User\UpdateUserAllergens;
use App\Actions\User\UpdateUserDetails;
use App\Enums\HttpCodes;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginOAuthRequest;
use App\Http\Requests\UnlinkAccountRequest;
use App\Http\Requests\UpdateUserAllergensRequest;
use App\Http\Requests\UpdateUserDetailsRequest;
use App\Http\Resources\ConnectedAccountResource;
use App\Http\Resources\OnboardingUserResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Check if user has a password
     *
     * @return JsonResponse
     */
    public function checkPassword(): JsonResponse
    {
        $user = Auth::user();

        return $this->sendResponse([
            'has_password' => !is_null($user->password)
        ]);
    }

    /**
     * Get minimum user details
     *
     * @return JsonResponse
     */
    public function getMiniatureUser(): JsonResponse
    {
        $user = Auth::user();

        return $this->sendResponse([
            'user' => new OnboardingUserResource($user)
        ]);
    }

    /**
     * Update user details
     *
     * This endpoint is used to update the current logged-in user's details.
     *
     * @param UpdateUserDetailsRequest $request
     * @param UpdateUserDetails $action
     * @return JsonResponse
     */
    public function updateDetails(UpdateUserDetailsRequest $request, UpdateUserDetails $action): JsonResponse
    {
        $user = $action->execute($request);

        return $this->sendResponse([
            'user' => new UserResource($user)
        ]);
    }

    /**
     * Change user password
     *
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $user = Auth::user();
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return $this->sendResponse([
            'message' => 'Password changed successfully'
        ]);
    }

    /**
     * Get user allergens
     *
     * This endpoint is used to get the current logged-in user's allergens.
     *
     * @return JsonResponse
     */
    public function getUserAllergens(): JsonResponse
    {
        $user = Auth::user();

        return $this->sendResponse([
            'allergens' => $user->allergens
        ]);
    }

    /**
     * Update user allergens
     *
     * This endpoint is used to update the current logged-in user's allergens.
     *
     * @throws \Throwable
     */
    public function updateAllergens(UpdateUserAllergensRequest $request, UpdateUserAllergens $action): JsonResponse
    {
        $allergenIds = $request->input('allergens');

        try {
            $allergens = $action->execute($allergenIds);
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 'SERVER_ERROR');
        }

        return $this->sendResponse([
            'allergens' => $allergens,
            'message' => 'Allergens updated successfully'
        ]);
    }

    /**
     * Get connected accounts
     *
     * This endpoint is used to get the current logged-in user's connected accounts.
     *
     * @return JsonResponse
     */
    public function getConnectedAccounts(): JsonResponse
    {
        $user = Auth::user();

        return $this->sendResponse([
            'accounts' => ConnectedAccountResource::collection($user->connectedAccounts)
        ]);
    }

    /**
     * Link third-party accounts to user
     *
     * This endpoint is used to link a third-party account to the current logged-in user.
     *
     * @param LoginOAuthRequest $request
     * @param LinkAccount $action
     * @return JsonResponse
     */
    public function linkAccount(LoginOAuthRequest $request, LinkAccount $action): JsonResponse
    {
        $credentials = $request->only('email', 'first_name', 'last_name', 'access_token', 'provider', 'device_type');

        return $action->execute($credentials);
    }

    /**
     * Unlink connected account
     *
     * This endpoint is used to unlink a connected account from the current logged-in user.
     *
     * @param UnlinkAccountRequest $request
     * @return JsonResponse
     */
    public function unlinkAccount(UnlinkAccountRequest $request): JsonResponse
    {
        $user = Auth::user();

        // Do not allow unlinking if the user has no password
//        if (is_null($user->password) && $user->connectedAccounts()->count() <= 1) {
//            return $this->sendErrorResponse(
//                'You cannot unlink your last account if you have no password.',
//                HttpCodes::FORBIDDEN->value,
//                null,
//                HttpCodes::FORBIDDEN->getHttpStatusCode()
//            );
//        }

        $user->connectedAccounts()->where('provider', $request->input('provider'))->delete();

        return $this->sendResponse([
            'message' => 'Account unlinked successfully'
        ]);
    }
}
