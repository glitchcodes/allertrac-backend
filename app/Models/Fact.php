<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Fact extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'references'
    ];

    /**
     * Get the author of the fact.
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the category of the fact.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(FactCategory::class, 'category_id');
    }

    /**
     * Get the cover image of the fact.
     *
     * Automatically prepends the storage URL to the cover image path.
     *
     * @return Attribute
     */
    protected function coverImage(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Storage::disk('backblaze')->url($value)
        );
    }
}
