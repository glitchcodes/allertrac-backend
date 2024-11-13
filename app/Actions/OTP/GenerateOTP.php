<?php

namespace App\Actions\OTP;

use Illuminate\Support\Facades\Cache;

readonly class GenerateOTP
{
    public function execute(string $type, int $userId): array
    {
        $identifier = "otp:{$type}:{$userId}"; // TODO: Add random string at the end to prevent brute force

        $otp = mt_rand(1000, 9999);

        // Remove old OTP if exists
        if (Cache::has($identifier)) {
            Cache::forget($identifier);
        }

        // Save the OTP to the cache
        Cache::put($identifier, $otp, now()->addMinutes(15));

        return [
            'identifier' => $identifier,
            'code' => $otp
        ];
    }
}
