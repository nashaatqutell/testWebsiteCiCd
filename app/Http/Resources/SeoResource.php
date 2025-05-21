<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeoResource extends JsonResource
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
            "page_name" => $this->page_name ?? null,
            "meta_name" => $this->meta_name ?? null,
            "meta_description" => $this->meta_description ?? null,
            "meta_keywords" => $this->meta_keywords ?? null,
        ];
    }
}
