<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\SimpleDataResource;
use App\Http\Resources\StaticPageResource;
use App\Models\StaticPage\StaticPage;
use App\Service\StaticPageService;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    protected $staticPageService;
    public function __construct(StaticPageService $staticPageService)
    {
        $this->staticPageService = $staticPageService;
        $this->middleware('permission:show_staticPages')->only(['index', 'show']);
        $this->middleware('permission:create_staticPages')->only(['store']);
        $this->middleware('permission:update_staticPages')->only(['update']);
        $this->middleware('permission:delete_staticPages')->only(['destroy']);
        $this->middleware('permission:active_staticPages')->only(['changeStatus']);
    }

    public function index()
    {
        $staticPages = $this->staticPageService->index('paginate');
        return $this->paginateResponse(StaticPageResource::collection($staticPages), $staticPages);
    }

    public function list()
    {
        $staticPages = $this->staticPageService->list();
        return $this->successResponse(
            SimpleDataResource::collection($staticPages),
            __('staticPage.retrieved_successfully')
        );
    }

    public function store(Request $request)
    {
        $staticPage = $this->staticPageService->store($request);
        return $this->successResponse(data: $staticPage->getResource(), message: __('staticpage.created_successfully'));
    }


    public function show(StaticPage $staticPage)
    {
        $staticPage = $this->staticPageService->show($staticPage);
        return $this->successResponse(StaticPageResource::make($staticPage), __('staticpage.retrieved_successfully'));
    }


    public function update(Request $request, StaticPage $staticPage)
    {
        $staticPage = $this->staticPageService->update($request, $staticPage);
        return $this->successResponse(data: $staticPage->getResource(), message: __('staticpage.updated_successfully'));
    }

    public function destroy(StaticPage $staticPage)
    {
        $this->staticPageService->destroy($staticPage);
        return $this->successResponse(null, __('staticpage.deleted_successfully'));
    }

    public function changeStatus(StaticPage $staticPage)
    {
        $this->staticPageService->changeStatus($staticPage);
        return $this->successResponse(message: __('staticpage.status_updated_successfully'));
    }

}
