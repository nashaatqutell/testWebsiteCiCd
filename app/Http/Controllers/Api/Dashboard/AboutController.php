<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\About\StoreAboutRequest;
use App\Http\Requests\Dashboard\About\UpdateAboutRequest;
use App\Http\Resources\AboutResource;
use App\Http\Resources\SimpleDataResource;
use App\Models\About\About;
use App\Service\AboutService;

class AboutController extends Controller
{
    protected $aboutService;

    public function __construct(AboutService $aboutService)
    {
        $this->middleware('permission:show_abouts')->only(['index','show']);
        $this->middleware('permission:create_abouts')->only(['store']);
        $this->middleware('permission:update_abouts')->only(['update']);
        $this->middleware('permission:delete_abouts')->only(['destroy']);
        $this->middleware('permission:active_abouts')->only(['changeStatus']);

        $this->aboutService = $aboutService;
    }

    public function index()
    {
        $abouts = $this->aboutService->getAllAbouts('paginate');
        return $this->paginateResponse(AboutResource::collection($abouts), $abouts);
    }

    public function list()
    {
        $abouts = $this->aboutService->listAbouts();
        return $this->successResponse(SimpleDataResource::collection($abouts));
    }

    public function store(StoreAboutRequest $request)
    {
        $about = $this->aboutService->storeAbout($request->validated());
        return $this->successResponse(data: $about->getResource(), message: __('messages.success'));
    }

    public function show(About $about)
    {
        return $this->successResponse(data: AboutResource::make($about));
    }

    public function update(UpdateAboutRequest $request, About $about)
    {
        $about = $this->aboutService->updateAbout($about, $request->validated());
        return $this->successResponse(data: $about->getResource(), message: __('messages.update'));
    }

    public function destroy(About $about)
    {
        $this->aboutService->deleteAbout($about);
        return $this->successResponse(message: __('messages.delete'));
    }

    public function changeStatus(About $about)
    {
        $this->aboutService->toggleAboutStatus($about);
        return $this->successResponse(message: __('messages.update'));
    }
}
