<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaticPageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            'name' => $this->name,
            'slug'=> $this->slug,
            'description' => $this->description,
            'meta_description' => $this->meta_description,
            'image' => url($this->getFirstMediaUrl('staticPage_images')) ?: null,
            'is_active'=> $this->is_active,
            "added_by" => SimpleDataResource::make($this->AddedBy) ?? null,
            'created_at' => $this?->created_at?->toDateTimeString() ?? null,
        ];
    }
}
