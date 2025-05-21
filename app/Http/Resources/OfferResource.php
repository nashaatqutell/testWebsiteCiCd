<?php

namespace App\Http\Resources;

use App\Enums\User\ActiveEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
            "name" => $this->name ?? null,
            "description" => $this->description ?? null,
            "price" => $this->price ?? null,
            "discount_percent" => $this->discount_percent ?? 0,
//            "status" => ActiveEnum::getKey($this->is_active ?? null),
            "created_at" => convertCreatedAt($this->created_at ?? null),
        ];
    }
}
