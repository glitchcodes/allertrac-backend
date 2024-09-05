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
use App\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function check(): JsonResponse
    {
        $user = Auth::user();

        return $this->sendResponse([
            'user' => $user,
            'message' => 'You are authenticated.'
        ]);
    }

    public function login(LoginRequest $request, LoginUser $action): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        return $action->execute($credentials);
    }

    public function loginOAuth(LoginOAuthRequest $request, LoginOAuthUser $action): JsonResponse
    {
        $credentials = $request->only('email', 'first_name', 'last_name');

        return $action->execute($credentials);
    }

    public function register(RegisterRequest $request, CreateUser $action): JsonResponse
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $response = $action->execute($credentials, false);

        return $this->sendResponse($response);
    }

    public function verifyAccount(VerifyOTPRequest $request, VerifyOTP $verifyOTP, VerifyUserEmail $verifyAccount): JsonResponse
    {
        $identifier = $request->input('identifier');
        $code = $request->input('code');

        if ($verifyOTP->execute($identifier, $code)) {
            $userId = explode(':', $identifier)[2];
            $verifyAccount->execute($userId);

            return $this->sendResponse([
                'message' => 'Email verified. Please login to continue.'
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
}
