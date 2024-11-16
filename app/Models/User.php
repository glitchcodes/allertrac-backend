<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Handle events
     *
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();

        static::creating(fn (Authenticatable $model) =>
            $model->anon_id = (string) \Str::ulid()
        );
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'avatar',
        'phone_number',
        'birthday',
        'email_verified_at',
        'is_onboarding',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_onboarding' => 'boolean',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the full name of the user.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's avatar.
     *
     * Automatically prepends the storage URL to the avatar path.
     *
     * @return Attribute
     */
    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn (string|null $value) => $value ? Storage::disk('backblaze')->url($value) : ''
        );
    }

    /**
     * Check if the user's email is verified.
     *
     * @return bool
     */
    public function isEmailVerified(): bool
    {
        return $this->email_verified_at !== null;
    }

    /**
     * Get user's allergens
     *
     * @return BelongsToMany
     */
    public function allergens(): BelongsToMany
    {
        return $this->belongsToMany(Allergen::class, 'user_allergens');
    }

    /**
     * Get the user's emergency contacts
     *
     * @return HasMany
     */
    public function emergencyContacts(): HasMany
    {
        return $this->hasMany(EmergencyContact::class);
    }

    /**
     * Get the user's bookmarked meals
     *
     * @return HasMany
     */
    public function bookmarkedMeals(): HasMany
    {
        return $this->hasMany(BookmarkedMeal::class);
    }

    /**
     * Get the user's connected accounts (OAuth)
     *
     * @return HasMany
     */
    public function connectedAccounts(): HasMany
    {
        return $this->hasMany(ConnectedAccount::class);
    }

    /**
     * Get the user's alarms
     *
     * Returns HasOne because alarms are stored in JSON
     *
     * @return HasOne
     */
    public function alarms(): HasOne
    {
        return $this->hasOne(Alarm::class);
    }
}
