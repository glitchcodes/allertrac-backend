<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class ScannedMealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        Log::info('Scanned Meal', ['context' => $this->resource]);

        return [
            'analysis_id' => $this->analysis_id,
            'items' => FoodResource::collection($this->items),
        ];
    }
}
