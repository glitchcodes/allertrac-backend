<?php

namespace App\Http\Resources;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'confidence' => $this['confidence'],
            'ingredients' => $this['ingredients'],
            'food_info' => [
                'food_id' => $this['food_info']['food_id'],
                'fv_grade' => $this['food_info']['fv_grade'],
                'display_name' => $this['food_info']['display_name'],
                'allergens' => $this->allergens()
            ]
        ];
    }

    public function allergens()
    {
        return Food::where('food_id', $this['food_info']['food_id'])->first()->allergens;
    }
}
