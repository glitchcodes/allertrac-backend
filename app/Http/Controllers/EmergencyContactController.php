<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmergencyContactRequest;
use App\Http\Resources\EmergencyContactResource;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;

class EmergencyContactController extends Controller
{
    use ApiResponseTrait;

    private Authenticatable|User $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * Get all emergency contacts
     *
     * This endpoint returns all emergency contacts for the authenticated user
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $contacts = $this->user->emergencyContacts;

        return $this->sendResponse([
            'contacts' => EmergencyContactResource::collection($contacts)
        ]);
    }

    /**
     * Create an emergency contact
     *
     * This endpoint allows the authenticated user to create an emergency contact
     *
     * @param EmergencyContactRequest $request
     * @return JsonResponse
     */
    public function store(EmergencyContactRequest $request): JsonResponse
    {
        $contact = $this->user->emergencyContacts()->create($request->validated());

        return $this->sendResponse([
            'contact' => new EmergencyContactResource($contact),
            'message' => 'Emergency contact created successfully'
        ]);
    }

    /**
     * Update an emergency contact
     *
     * This endpoint allows the authenticated user to update an emergency contact
     *
     * @param EmergencyContactRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(EmergencyContactRequest $request, int $id): JsonResponse
    {
        try {
            $contact = $this->user->emergencyContacts()->findOrFail($id);
            $contact->update($request->validated());

            return $this->sendResponse([
                'contact' => new EmergencyContactResource($contact),
                'message' => 'Emergency contact updated successfully'
            ]);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Emergency contact not found', 404);
        }
    }

    /**
     * Delete an emergency contact
     *
     * This endpoint allows the authenticated user to delete an emergency contact
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        try {
            $contact = $this->user->emergencyContacts()->findOrFail($id);
            $contact->delete();

            return $this->sendResponse([
                'message' => 'Emergency contact deleted successfully'
            ]);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Emergency contact not found', 404);
        }
    }
}
