<?php

namespace App\Http\Resources;

use App\Models\Fact;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Fact
 */
class FactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'brief_description' => $this->brief_description,
            'category' => $this->category->name,
            'category_id' => $this->category_id,
            'cover_image' => $this->cover_image,
            'references' => $this->references,
            'author' => new AuthorResource($this->author),
            'is_published' => $this->is_published
        ];
    }
}
