<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartnerResource;
use App\Models\Partner\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function __invoke(Request $request)
    {
        $partners = Partner::whereIsActive()->latest()->get();
        return $this->successResponse(PartnerResource::collection($partners));
    }

}
