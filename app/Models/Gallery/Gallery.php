<?php

namespace App\Models\Gallery;

use App\Http\Resources\GalleryResource;
use App\Models\BaseModel;

class Gallery extends BaseModel
{

    protected $table = 'galleries';

    protected $fillable = [
        'is_active',
        "added_by_id"
    ];

    public function getResource(): GalleryResource
    {
        return new GalleryResource($this->fresh());
    }
}
