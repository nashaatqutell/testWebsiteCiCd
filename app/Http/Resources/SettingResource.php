<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name ?? null,
            "description" => $this->description ?? null,
            "address" => $this->address ?? null,
            "notes_and_suggestions" => $this->notes_and_suggestions ?? null,
            "slogan" => $this->footer_description ?? null,
            "copyrights" => $this->footer_description2 ?? null,
            'logo_light' => url($this->getFirstMediaUrl('logo')) ?? null, // Get logo URL
            "logo_dark" => url($this->getFirstMediaUrl('logo2')) ?? null,
            "favicon" => url($this->getFirstMediaUrl('favicon')) ?? null,
            "financial_menus_image" => url($this->getFirstMediaUrl('financial_menus_image')) ?? null,
            "footer_image" => url($this->getFirstMediaUrl('footer_image')) ?? null,
            "email" => $this->email ?? null,
            "phone" => $this->phone ?? null,
            "phone2" => $this->phone2 ?? null,
            "support_phone" => $this->support_phone ?? null,
            "location" => $this->location ?? null,
            "embed_map" => $this->embed_map ?? null,
            "facebook" => $this->facebook ?? null,
            "instagram" => $this->instagram ?? null,
            "youtube" => $this->youtube ?? null,
            "tiktok" => $this->tiktok ?? null,
            "whatsapp" => $this->whatsapp ?? null,
            "x" => $this->x ?? null,
        ];
    }
}
