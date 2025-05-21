<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\HeroSection\UpdateHeroSectionRequest;
use App\Http\Resources\HeroSectionResource;
use App\Models\HeroSection\HeroSection;
use App\Service\HeroSectionService;

class HeroSectionController extends Controller
{
    protected $heroSectionService;
    public function __construct(HeroSectionService $heroSectionService)
    {
        $this->heroSectionService = $heroSectionService;
        $this->middleware('permission:show_heroSection')->only(['index', 'show']);
        $this->middleware('permission:update_heroSection')->only(['update']);
    }

    public function index()
    {
        $heroSections = $this->heroSectionService->index('paginate');
        return $this->paginateResponse(HeroSectionResource::collection($heroSections), $heroSections);
    }

    public function update(UpdateHeroSectionRequest $request, HeroSection $heroSection)
    {

        $heroSection = $this->heroSectionService->update($request, $heroSection);
        return $this->successResponse(
            data: $heroSection->getResource(),
            message: __('heroSection.updated_successfully')
        );
    }
}
