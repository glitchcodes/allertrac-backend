<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmergencyContactRequest;
use App\Http\Resources\EmergencyContactResource;
use App\Jobs\SendEmergencyText;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class EmergencyContactController extends Controller
{
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

    /**
     * @throws \Throwable
     */
    public function sendEmergencyTexts(): JsonResponse
    {
        $jobs = [];
        $contacts = $this->user->emergencyContacts;

        foreach ($contacts as $contact) {
//            $message = 'Alert! This is an emergency message from ' . $this->user->full_name .' because you\'re their contact. Please contact them immediately.';
            $message = 'Your water refill is now ready for delivery';

            $jobs[] = new SendEmergencyText($contact->phone_number, $message);
        }

        try {
            $batch = Bus::batch($jobs)->dispatch();

            Log::info('SMS Batch ID: ' . $batch->id);

            return $this->sendResponse([
                'message' => 'Emergency texts sent successfully'
            ]);
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 'SERVER_ERROR');
        }
    }
}
