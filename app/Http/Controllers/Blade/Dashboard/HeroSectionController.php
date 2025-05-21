<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\HeroSection\UpdateHeroSectionRequest;
use App\Models\HeroSection\HeroSection;
use App\Service\HeroSectionService;
use Illuminate\Http\Request;

class HeroSectionController extends Controller
{
    protected $heroSectionService;

    public function  __construct(HeroSectionService $heroSectionService)
    {
        $this->heroSectionService = $heroSectionService;
        $this->middleware('permission:show_heroSection')->only(['index']);
        $this->middleware('permission:update_heroSection')->only(['update']);
    }

    public function index()
    {
        $heroSections = $this->heroSectionService->index('get');
        return view('dashboard.heroSections.index',get_defined_vars());
    }

    public function edit(HeroSection $heroSection)
    {
        return view('dashboard.heroSections.single', get_defined_vars());
    }


    public function update(UpdateHeroSectionRequest $request, HeroSection  $heroSection)
    {
        $this->heroSectionService->update($request, $heroSection);
        return redirect()->route('admin.hero_sections.edit', $heroSection->id)->with(
            array(
                "message" => __("messages.update"),
                "alert-type" => "success"
            )
        );
    }
}
