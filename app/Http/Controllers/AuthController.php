<?php

namespace App\Http\Controllers;

use App\Actions\OTP\ResendOTP;
use App\Actions\OTP\VerifyOTP;
use App\Actions\User\CreateUser;
use App\Actions\User\LoginOAuthUser;
use App\Actions\User\LoginUser;
use App\Actions\User\VerifyUserEmail;
use App\Enums\HttpCodes;
use App\Http\Requests\LoginOAuthRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResendOTPRequest;
use App\Http\Requests\VerifyOTPRequest;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponseTrait;

    /**
     * Check Authentication Status
     *
     * @return JsonResponse
     */
    public function check(): JsonResponse
    {
        $user = Auth::user();

        return $this->sendResponse([
            'user' => new UserResource($user),
            'message' => 'You are authenticated.'
        ]);
    }

    /**
     * Login (Email/Password)
     *
     * @unauthenticated
     *
     * @response array{ token: string, user: \App\Models\User, redirect_to: string }
     *
     * @param LoginRequest $request
     * @param LoginUser $action
     * @return JsonResponse
     */
    public function login(LoginRequest $request, LoginUser $action): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        return $action->execute($credentials);
    }

    /**
     * Login (OAuth)
     *
     * @unauthenticated
     *
     * @response array{ token: string, user: \App\Models\User, redirect_to: string }
     *
     * @param LoginOAuthRequest $request
     * @param LoginOAuthUser $action
     * @return JsonResponse
     */
    public function loginOAuth(LoginOAuthRequest $request, LoginOAuthUser $action): JsonResponse
    {
        $credentials = $request->only('email', 'first_name', 'last_name', 'account_id', 'provider', 'id_token');

        return $action->execute($credentials);
    }

    /**
     * Register User
     *
     * @unauthenticated
     * @param RegisterRequest $request
     * @param CreateUser $action
     * @return JsonResponse
     */
    public function register(RegisterRequest $request, CreateUser $action): JsonResponse
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $response = $action->execute($credentials, false);

        return $this->sendResponse($response);
    }

    /**
     * Verify account email
     *
     * @unauthenticated
     *
     * @response array{ message: "Email verified. Please log in to continue." }
     *
     * @param VerifyOTPRequest $request
     * @param VerifyOTP $verifyOTP
     * @param VerifyUserEmail $verifyAccount
     * @return JsonResponse
     */
    public function verifyAccount(VerifyOTPRequest $request, VerifyOTP $verifyOTP, VerifyUserEmail $verifyAccount): JsonResponse
    {
        $identifier = $request->input('identifier');
        $code = $request->input('code');

        if ($verifyOTP->execute($identifier, $code)) {
            $userId = explode(':', $identifier)[2];
            $verifyAccount->execute($userId);

            return $this->sendResponse([
                'message' => 'Email verified. Please log in to continue.'
            ]);
        } else {
            return $this->sendErrorResponse(
                'Invalid OTP',
                HttpCodes::INPUT_INVALID->value,
                null,
                HttpCodes::INPUT_INVALID->getHttpStatusCode()
            );
        }
    }

    /**
     * Resend Verification Code
     *
     * This endpoint handles the resending of the OTP (One-Time Password) for user verification.
     *
     * The `identifier` parameter is used to identify the user to whom the OTP will be sent.
     *
     * @unauthenticated
     * @param ResendOTPRequest $request The request object containing the identifier.
     * @param ResendOTP $action The action to execute the OTP resend.
     * @return JsonResponse The JSON response indicating success or failure.
     */
    public function resendVerificationCode(ResendOTPRequest $request, ResendOTP $action): JsonResponse
    {
        try {
            $action->execute($request->input('identifier'));

            return $this->sendResponse([
                'message' => 'OTP successfully sent'
            ]);
        } catch (ModelNotFoundException $exception) {
            return $this->sendErrorResponse(
                'No user found with the provided identifier',
                HttpCodes::NOT_FOUND->value,
                null,
                HttpCodes::NOT_FOUND->getHttpStatusCode()
            );
        }
    }

    /**
     * Logout User
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        // Invalidate current user token
        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse([
            'message' => 'Successfully logged out.'
        ]);
    }
}
