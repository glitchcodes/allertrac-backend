<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class VerifyUserEmail
{
    public function execute(int $userId): User
    {
        $user = User::where('id', '=', $userId)->firstOrFail();

        $user->update([
            'email_verified_at' => now()
        ]);

        return $user;
    }
}
