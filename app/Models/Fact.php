<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Fact extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'author_id',
        'category_id',
        'title',
        'description',
        'brief_description',
        'cover_image',
        'references',
        'is_published'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean'
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
            get: fn (string|null $value) => $value ? Storage::disk('backblaze')->url($value) : ''
        );
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }
}
