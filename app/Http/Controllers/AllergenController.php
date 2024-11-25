<?php

namespace App\Http\Controllers;

use App\Models\Allergen;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class AllergenController extends Controller
{
    /**
     * List Allergens
     *
     * @response array{ allergens: \App\Models\Allergen[] }
     * @return JsonResponse
     */
    public function getAllergens(): JsonResponse
    {
        $allergens = Allergen::all();

        return $this->sendResponse(['allergens' => $allergens]);
    }

    public function getStatistics(): JsonResponse
    {
        $statistics = Allergen::withCount('users')->get()->map(function ($allergen) {
            return [
                'allergen' => $allergen->name,
                'user_count' => $allergen->users_count,
            ];
        });

        return $this->sendResponse(['statistics' => $statistics]);
    }
}
