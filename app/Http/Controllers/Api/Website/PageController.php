<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Page\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __invoke(Request $request)
    {
        $pages = Page::whereIsActive()->latest()->get();
        return $this->successResponse(PageResource::collection($pages));
    }
}
