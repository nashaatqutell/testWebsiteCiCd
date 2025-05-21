<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use App\Models\Offer\Offer;

class OfferController extends Controller
{

    public function __invoke()
    {
        $offers = Offer::query()->latest()->whereIsActive()->get();
        return $this->successResponse(OfferResource::collection($offers),message: __("messages.fetched_successfully"));
    }
}
