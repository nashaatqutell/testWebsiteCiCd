<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            "guard_name" => $this->guard_name ?? null,
            "created_at" => convertCreatedAt($this->created_at ?? null),
            "permissions" => $this->permissions->pluck('name'),
        ];
    }
}
