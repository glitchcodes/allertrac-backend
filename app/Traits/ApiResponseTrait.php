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

    public function sendErrorResponse(
        string $message,
        string $code,
        mixed $errors = null,
        mixed $statusCode = HttpCodes::INTERNAL_SERVER_ERROR,
        mixed $data = null
    ): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'code' => $code,
            'payload' => $data,
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
