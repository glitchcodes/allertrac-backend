<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookmarkedMeal extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'uri'
    ];

    /**
     * Get the user that owns the bookmarked meal.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
