<?php

namespace App\Actions\User;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\UpdateUserDetailsRequest;
use Illuminate\Support\Facades\Storage;

class UpdateUserDetails
{
    private User $user;

    public function __construct() {
        $this->user = Auth::user();
    }

    public function execute(UpdateUserDetailsRequest $request): User
    {
        if ($request->hasFile('avatar')) {
            $filename = $this->user->anon_id . '-' . time() . '.' . $request->file('avatar')->extension();
            Storage::disk('backblaze')->putFileAs('avatars', $request->file('avatar'), $filename);

            $this->user->update([
                'avatar' => 'avatars/' . $filename
            ]);
        } else {
            $this->user->update([
                'avatar' => null
            ]);
        }

        $this->user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone_number' => $request->input('phone_number'),
            'birthday' => $request->input('birthday')
        ]);

        return $this->user;
    }
}
