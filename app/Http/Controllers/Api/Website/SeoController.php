<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\SeoResource;
use App\Models\Seo\Seo;

class SeoController extends Controller
{

    public function __invoke()
    {
        $seos = Seo::query()->latest()->whereIsActive()->get();
        return $this->successResponse(SeoResource::collection($seos),message: __("messages.fetched_successfully"));
    }
}
