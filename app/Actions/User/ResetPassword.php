<?php

namespace App\Actions\User;

readonly class ResetPassword
{
    public function execute(string $userId): array
    {
        // Reset the password
        $user = User::findOrFail($userId);

        $user->update([
            'password' => bcrypt($credentials['password'])
        ]);

        return [
            'message' => 'Password reset successful.'
        ];
    }
}
