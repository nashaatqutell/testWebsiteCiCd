<?php

namespace App\Http\Resources;

use App\Enums\User\ActiveEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnerResource extends JsonResource
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
            'link' => $this->link,
            'image' => url($this->getFirstMediaUrl('partner_images')) ?: null,
            'is_active' => ActiveEnum::getValue($this->is_active),
            "added_by" => SimpleDataResource::make($this->AddedBy) ?? null
        ];
    }
}
