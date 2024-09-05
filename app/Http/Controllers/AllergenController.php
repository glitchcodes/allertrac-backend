<?php

namespace App\Http\Controllers;

use App\Models\Allergen;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class AllergenController extends Controller
{
    use ApiResponseTrait;

    public function getAllergens(): JsonResponse
    {
        $allergens = Allergen::all();

        return $this->sendResponse(['allergens' => $allergens]);
    }
}
