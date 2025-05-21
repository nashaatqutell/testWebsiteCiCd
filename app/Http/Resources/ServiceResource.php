<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Enums\User\ActiveEnum;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            "parent_id" => $this->parent->name ?? null,
            'description' => $this->description,
            "images" =>  $this->getMedia('service_images')->map(fn($media) => url($media->getUrl())),
            'video' => url($this->getFirstMediaUrl('service_videos')) ?: null,
            'is_active' => ActiveEnum::getValue($this->is_active),
            "added_by" => SimpleDataResource::make($this->AddedBy) ?? null,
            'created_at' => $this->created_at->toDateTimeString(),
//            "children" => ServiceResource::collection($this->whenLoaded("children") ?? []),
        ];
    }
}
