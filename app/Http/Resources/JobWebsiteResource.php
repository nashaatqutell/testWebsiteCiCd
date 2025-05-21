<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobWebsiteResource extends JsonResource
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
            'position' => $this->position,
            'description' => $this->description,
//            'children'    => JobWebsiteResource::collection($this->children),
            "image" => url($this->getFirstMediaUrl('job_images')) ?: null,
        ];
    }
}
