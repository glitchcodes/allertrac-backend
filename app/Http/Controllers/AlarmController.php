<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveAlarmRequest;
use App\Http\Resources\AlarmResource;
use App\Models\Alarm;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AlarmController extends Controller
{
    private User $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function getAlarms(): \Illuminate\Http\JsonResponse
    {
        $alarms = Alarm::where('user_id', $this->user->id)->first();

        if ($alarms === null) {
            return $this->sendResponse([]);
        }

        return $this->sendResponse(new AlarmResource($alarms));
    }

    public function saveAlarms(SaveAlarmRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->user->alarms()->updateOrCreate([
            'user_id' => $this->user->id,
        ], [
            'alarms' => $request->alarms,
        ]);

        return response()->json(new AlarmResource($this->user->alarms));
    }
}
