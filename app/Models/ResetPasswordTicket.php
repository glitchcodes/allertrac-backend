<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ResetPasswordTicket extends Model
{
    use HasUlids;

    public $incrementing = false;
    protected $primaryKey = 'token';
    protected $keyType = 'string';

    /**
     * Disable timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Populate the token and expires_at fields before creating the model
     *
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->token = Str::ulid();
            $model->expires_at = now()->addMinutes(15);
        });
    }

    /**
     * Mass assignable attributes
     *
     * @var string[] $fillable
     */
    protected $fillable = [
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the ticket is expired
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return now()->gt($this->expires_at);
    }
}
