<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\HeroSectionResource;
use App\Models\HeroSection\HeroSection;
use Illuminate\Http\Request;

class HeroSectionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $heroSections = HeroSection::whereIsActive()->first();
        return $this->successResponse(HeroSectionResource::make($heroSections));
    }
}
