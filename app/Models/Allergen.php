<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperAllergen
 */
class Allergen extends Model
{
    use HasFactory;

    // Hide pivot data
    protected $hidden = ['pivot'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_allergens');
    }

    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(
            Food::class,
            'food_allergens',
            'allergen_id',
            'food_id',
            'id',
            'food_id'
        );
    }
}
