<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Gallery\StoreGalleryRequest;
use App\Http\Requests\Dashboard\Gallery\UpdateGalleryRequest;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery\Gallery;
use App\Service\GalleryService;

class GalleryController extends Controller
{
    public function __construct(protected GalleryService $GalleryService = new GalleryService())
    {
        $this->middleware('permission:show_galleries')->only(['index','show']);
        $this->middleware('permission:create_galleries')->only(['store']);
        $this->middleware('permission:update_galleries')->only(['update']);
        $this->middleware('permission:delete_galleries')->only(['destroy']);
        $this->middleware('permission:active_galleries')->only(['changeStatus']);
    }

    public function index()
    {
        $Galleries = $this->GalleryService->index('paginate');
        return $this->paginateResponse(
            data: GalleryResource::collection($Galleries),
            collection: $Galleries
        );
    }

    public function list()
    {
        $Galleries = $this->GalleryService->list();
        return $this->successResponse(data: GalleryResource::collection($Galleries),message: __("messages.fetched_successfully"));
    }

    public function store(StoreGalleryRequest $request)
    {
        $Gallery = $this->GalleryService->store($request);
        return $this->successResponse(data:$Gallery->getResource(), message: __("messages.success"));
    }

    public function update(UpdateGalleryRequest $request, Gallery $Gallery)
    {
        $Gallery = $this->GalleryService->update($request, $Gallery);
        return $this->successResponse(data: $Gallery->getResource(), message: __("messages.update"));
    }

    public function show(Gallery $Gallery)
    {
        return $this->successResponse(data: GalleryResource::make($Gallery),message: __("messages.fetched_successfully"));
    }


    public function destroy(Gallery $Gallery)
    {
       $this->GalleryService->destroy($Gallery);
        return $this->successResponse(message: __("messages.delete"));
    }

    public function changeStatus(Gallery $Gallery)
    {
        $Gallery = $this->GalleryService->changeStatus($Gallery);
        return $this->successResponse(message: __("messages.update"));
    }
}
