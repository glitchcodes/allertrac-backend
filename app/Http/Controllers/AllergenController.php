<?php

namespace App\Http\Controllers;

use App\Models\Allergen;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class AllergenController extends Controller
{
    use ApiResponseTrait;

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
}
