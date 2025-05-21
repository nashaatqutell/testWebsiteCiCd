<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery\Gallery;

class GalleryController extends Controller
{

    public function __invoke()
    {
        $Galleries = Gallery::query()->latest()->whereIsActive()->with("media")->get();
        return $this->successResponse(GalleryResource::collection($Galleries));
    }
}
