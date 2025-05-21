<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceWithChildrenByIdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $nextNode = $this->getNextNode();

        $data = [
            "id" => $this->id,
            'name' => $this->name,
            'description' => $this?->description,
            'is_final' => ($nextNode && $nextNode->children->isEmpty()) || $this->children->isEmpty(),
        ];

        if (!$this->children->isEmpty()) {
            $data['child_services'] = ServiceWithChildrenByIdResource::collection($this->children);
        }

        return $data;
    }
}
