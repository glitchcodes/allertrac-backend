<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class UpdateUserAllergens
{
    private User $user;

    public function __construct() {
        $this->user = Auth::user();
    }

    /**
     * @throws Throwable
     */
    public function execute(array $allergenIds): void
    {
        try {
            DB::beginTransaction();

            $this->user->allergens()->sync($allergenIds);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            throw new \Exception('Failed to update allergens');
        }
    }
}
