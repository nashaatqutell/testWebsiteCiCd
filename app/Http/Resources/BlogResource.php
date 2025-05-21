<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            "slug" => $this->slug ?? null,
            "name" => $this->name ?? null,
            "description" => $this->description ?? null,
            'image' => url($this->getFirstMediaUrl('images')) ?? null, // Get image URL
            "created_at" => convertCreatedAt($this->created_at ?? null),
            "added_by" => new SimpleDataResource($this->AddedBy ?? null) ?? null
        ];
    }
}
