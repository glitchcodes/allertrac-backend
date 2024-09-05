<?php

namespace App\Traits;

use App\Enums\HttpCodes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    public function sendResponse($data, $status = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json($data, $status);
    }

    public function sendErrorResponse($message, $code, $errors = null, $statusCode = HttpCodes::INTERNAL_SERVER_ERROR): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

    public function sendInvalidInputResponse(Validator $validator): JsonResponse
    {
        return $this->sendErrorResponse(
            'The given data was invalid.',
            HttpCodes::INPUT_INVALID->value,
            $validator->errors(),
            HttpCodes::INPUT_INVALID->getHttpStatusCode()
        );
    }
}
