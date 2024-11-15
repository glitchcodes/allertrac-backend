<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alarm extends Model
{
    /**
     * Mass assignable attributes
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'alarms',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
