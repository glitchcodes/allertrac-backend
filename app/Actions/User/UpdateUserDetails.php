<?php

namespace App\Actions\User;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\UpdateUserDetailsRequest;

class UpdateUserDetails
{
    private User $user;

    public function __construct() {
        $this->user = Auth::user();
    }

    public function execute(UpdateUserDetailsRequest $request): User
    {
        $this->user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone_number' => $request->input('phone_number'),
            'birthday' => $request->input('birthday')
        ]);

        return $this->user;
    }
}
