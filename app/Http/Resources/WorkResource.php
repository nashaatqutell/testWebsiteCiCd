<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Enums\User\ActiveEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkResource extends JsonResource
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
            'description' => $this->description,
            'meta_description' =>$this->meta_description,
            'classification' => $this->classification,
            "images" => $this->getMedia('work_images')->map(fn($media) => $media->getUrl()),
            'video' => url($this->getFirstMediaUrl('work_videos')) ?: null,
            'is_active' => ActiveEnum::getValue($this->is_active),
            "added_by" => SimpleDataResource::make($this->AddedBy) ?? null,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
