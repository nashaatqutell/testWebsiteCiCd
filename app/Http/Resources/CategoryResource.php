<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"          => $this->id,
            "name"        => $this->name ?? null,
            'description' => $this->description ?? null,
            "image"       => url($this->getFirstMediaUrl('category_images')) ?: null,
            "added_by"    => SimpleDataResource::make($this->AddedBy) ?? null,
        ];
    }
}
