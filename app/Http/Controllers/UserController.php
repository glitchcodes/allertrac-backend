<?php

namespace App\Http\Controllers;

use App\Actions\User\UpdateUserAllergens;
use App\Actions\User\UpdateUserDetails;
use App\Http\Requests\UpdateUserAllergensRequest;
use App\Http\Requests\UpdateUserDetailsRequest;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    use ApiResponseTrait;

    public function updateDetails(UpdateUserDetailsRequest $request, UpdateUserDetails $action): JsonResponse
    {
        $user = $action->execute($request);

        return $this->sendResponse([
            'user' => $user
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function updateAllergens(UpdateUserAllergensRequest $request, UpdateUserAllergens $action): JsonResponse
    {
        $allergenIds = $request->input('allergens');

        try {
            $action->execute($allergenIds);
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 'SERVER_ERROR');
        }

        return $this->sendResponse([
            'message' => 'Allergens updated successfully'
        ]);
    }
}
