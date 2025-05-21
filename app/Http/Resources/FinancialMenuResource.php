<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FinancialMenuResource extends JsonResource
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
            "year" => $this->year ?? null,
            "icon" => url($this->getFirstMediaUrl('financial_icon')) ?: null,
            "file" => url($this->getFirstMediaUrl('financial_file')) ?: null,
            "added_by" => SimpleDataResource::make($this->AddedBy) ?? null,
        ];
    }
}
