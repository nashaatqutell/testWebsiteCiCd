<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\StaticPage\StaticPageRequest;
use App\Http\Resources\StaticPageResource;
use App\Models\StaticPage\StaticPage;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    /**
     * Handle the incoming request.
     */

    public function __invoke(Request $request)
    {
        $staticPages = StaticPage::whereIsActive()->latest()->get();
        return $this->successResponse(StaticPageResource::collection($staticPages));
    }

    public function fetchStaticPageBySlug(Request $request)
    {
        $staticPage = StaticPage::whereIsActive()->whereSlug($request->slug)->firstOrFail();
        return $this->successResponse(StaticPageResource::make($staticPage));
    }
}
