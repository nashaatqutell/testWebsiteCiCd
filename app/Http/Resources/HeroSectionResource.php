<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Enums\User\ActiveEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class HeroSectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $media = null;
        if ($this->media_type === 'image') {
            $media = $this->getFirstMediaUrl('heroSection_images') ? url($this->getFirstMediaUrl('heroSection_images')) : null;
        } elseif ($this->media_type === 'video') {
            $media = $this->getFirstMediaUrl('heroSection_videos') ? url($this->getFirstMediaUrl('heroSection_videos')) : null;
        }

        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "sub_description" => $this->sub_description,
            "image" => $media,
            'media_type' => $this->media_type,
            'is_active' => ActiveEnum::getValue($this->is_active),
            "added_by" => SimpleDataResource::make($this->AddedBy) ?? null,
        ];
    }
}
