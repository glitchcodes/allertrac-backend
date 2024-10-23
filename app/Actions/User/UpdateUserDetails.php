<?php

namespace App\Actions\User;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\UpdateUserDetailsRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateUserDetails
{
    private User $user;

    public function __construct() {
        $this->user = Auth::user();
    }

    public function execute(UpdateUserDetailsRequest $request): User
    {
        if ($request->filled('avatar')) {
            $avatar = $request->input('avatar');

            // Decode the data uri
            $data = explode(',', $avatar);
            // Determine the file extension
            $extension = explode('/', mime_content_type($avatar))[1];

            $filename = $this->user->anon_id . '-' . time() . '.' . $extension;
            Storage::disk('backblaze')->put('avatars/' . $filename, base64_decode($data[1]));

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
