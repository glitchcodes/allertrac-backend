<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Alarm
 */
class AlarmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'alarms' => $this->alarms,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
