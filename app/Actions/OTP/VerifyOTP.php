<?php

namespace App\Actions\OTP;

use Illuminate\Support\Facades\Cache;

readonly class VerifyOTP
{
    public function execute(string $identifier, int $otp): bool
    {
        $cachedOtp = Cache::get($identifier);

        if ($cachedOtp === $otp) {
            Cache::forget($identifier);
            return true;
        }

        return false;
    }
}
