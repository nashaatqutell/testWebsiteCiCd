<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Seo\StoreSeoRequest;
use App\Http\Requests\Dashboard\Seo\UpdateSeoRequest;
use App\Http\Resources\SeoResource;
use App\Http\Resources\SimpleDataResource;
use App\Models\Seo\Seo;
use App\Service\SeoService;

class SeoController extends Controller
{
    public function __construct(protected SeoService $SeoService = new SeoService())
    {
        $this->middleware('permission:show_seo')->only(['index','show']);
        $this->middleware('permission:create_seo')->only(['store']);
        $this->middleware('permission:update_seo')->only(['update']);
        $this->middleware('permission:delete_seo')->only(['destroy']);
        $this->middleware('permission:active_seo')->only(['changeStatus']);
    }

    public function index()
    {
        $seos = $this->SeoService->index('paginate');
        return $this->paginateResponse(data: SeoResource::collection($seos),collection: $seos);
    }

    public function list()
    {
        $seos = $this->SeoService->list();
        return $this->successResponse(data: SimpleDataResource::collection($seos),message: __("messages.fetched_successfully"));
    }

    public function store(StoreSeoRequest $request)
    {
        $seo = $this->SeoService->store($request);
        return $this->successResponse(data: $seo->getResource(), message: __("messages.success"));
    }
    public function show(Seo $seo)
    {
        return $this->successResponse(data: $seo->getResource());
    }
    public function update(UpdateSeoRequest $request, Seo $seo)
    {
        $seo = $this->SeoService->update($request, $seo);
        return $this->successResponse(data: $seo->getResource(), message: __("messages.success"));
    }
    public function destroy(Seo $seo)
    {
        $this->SeoService->destroy($seo);
        return $this->successResponse(message: __("messages.delete"));
    }
    public function changeStatus(Seo $seo)
    {
        $seo = $this->SeoService->changeStatus($seo);
        return $this->successResponse(data: $seo->getResource(), message: __("messages.status_updated_successfully"));
    }
}
