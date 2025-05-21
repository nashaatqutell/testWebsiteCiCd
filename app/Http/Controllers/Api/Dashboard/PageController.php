<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Page\StorePageRequest;
use App\Http\Requests\Dashboard\Page\UpdatePageRequest;
use App\Http\Resources\PageResource;
use App\Http\Resources\SimpleDataResource;
use App\Models\Page\Page;
use App\Service\PageService;

class PageController extends Controller
{
    protected  $pageService;
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
        $this->middleware('permission:show_pages')->only(['index', 'show']);
        $this->middleware('permission:create_pages')->only(['store']);
        $this->middleware('permission:update_pages')->only(['update']);
        $this->middleware('permission:delete_pages')->only(['destroy']);
        $this->middleware('permission:active_pages')->only(['changeStatus']);
    }

    public function index()
    {
        $pages = $this->pageService->index('paginate');
        return $this->paginateResponse(PageResource::collection($pages), $pages);
    }

    public function list()
    {
        $pages = $this->pageService->list();
        return $this->successResponse(
            SimpleDataResource::collection($pages),
            __('Page.retrieved_successfully')
        );
    }

    public function store(StorePageRequest $request)
    {
        $page = $this->pageService->store($request);
        return $this->successResponse(data: $page->getResource(), message: __('Page.created_successfully'));
    }


    public function show(Page $page)
    {
        $page = $this->pageService->show($page);
        return $this->successResponse(PageResource::make($page), __('Page.retrieved_successfully'));
    }


    public function update(UpdatePageRequest $request, Page $page)
    {
        $page = $this->pageService->update($request, $page);
        return $this->successResponse(data: $page->getResource(), message: __('Page.updated_successfully'));
    }

    public function destroy(Page $page)
    {
        $this->pageService->destroy($page);
        return $this->successResponse(null, __('Page.deleted_successfully'));
    }

    public function changeStatus(Page $page)
    {
        $this->pageService->changeStatus($page);
        return $this->successResponse(message: __('Page.status_updated_successfully'));
    }
}
