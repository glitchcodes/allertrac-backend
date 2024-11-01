<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Food extends Model
{
    // Disable auto-incrementing key generation
    public $incrementing = false;

    // Set the primary key field
    protected $primaryKey = 'food_id';

    // Set the primary key data type
    protected $keyType = 'string';

    // Hide pivot data
    protected $hidden = ['pivot'];

    public function allergens(): BelongsToMany
    {
        return $this->belongsToMany(
            Allergen::class,
            'food_allergens',
            'food_id',
            'allergen_id',
            'food_id',
            'id'
        );
    }
}
