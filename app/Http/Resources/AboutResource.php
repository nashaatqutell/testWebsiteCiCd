<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = $request->header('Accept-Language');
        $org_structure = url($this->getFirstMediaUrl('org_structure'));
        if ($lang == 'ar') {
            $org_structure = url($this->getFirstMediaUrl('org_structure_ar'));
        }
        return [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'description' => $this->description,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'image' => url($this->getFirstMediaUrl('about_images')) ?: null,
            'org_structure' => $org_structure ?: null,
            "added_by" => SimpleDataResource::make($this->AddedBy) ?? null
        ];
    }
}
