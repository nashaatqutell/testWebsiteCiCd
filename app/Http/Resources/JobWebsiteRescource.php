<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobWebsiteRescource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"       => $this->id,
            'name'     => $this->name,
            'position' => $this->position,
            'description' => $this->description,
            "image"    => url($this->getFirstMediaUrl('job_images')) ?: null,
        ];
    }
}
