<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Slider\StoreSliderRequest;
use App\Http\Requests\Dashboard\Slider\UpdateSliderRequest;
use App\Http\Resources\SimpleDataResource;
use App\Http\Resources\SliderResource;
use App\Models\Slider\Slider;
use App\Service\SliderService;

class SliderController extends Controller
{
    protected $sliderService;

    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
        $this->middleware('permission:show_sliders')->only(['index', 'show']);
        $this->middleware('permission:create_sliders')->only(['store']);
        $this->middleware('permission:update_sliders')->only(['update']);
        $this->middleware('permission:delete_sliders')->only(['destroy']);
        $this->middleware('permission:active_sliders')->only(['changeStatus']);
    }

    public function index()
    {
        $sliders = $this->sliderService->index('paginate');
        return $this->paginateResponse(SliderResource::collection($sliders), $sliders);
    }

    public function list()
    {
        $sliders = $this->sliderService->list();
        return $this->successResponse(SimpleDataResource::collection($sliders), __('slider.retrieved_successfully'));
    }

    public function store(StoreSliderRequest $request)
    {

        $slider = $this->sliderService->store($request);
        return $this->successResponse(data: $slider->getResource(), message: __('slider.created_successfully'));
    }


    public function show(Slider $slider)
    {
        $this->sliderService->show($slider);
        return $this->successResponse(SliderResource::make($slider), __('slider.retrieved_successfully'));
    }

    public function update(UpdateSliderRequest $request, Slider $slider)
    {
        $slider = $this->sliderService->update($request, $slider);
        return $this->successResponse(data: $slider->getResource(), message: __('slider.updated_successfully'));
    }

    public function destroy(Slider $slider)
    {
        $this->sliderService->destroy($slider);
        return $this->successResponse(null, __('slider.deleted_successfully'));
    }

    public function changeStatus(Slider $slider)
    {
        $this->sliderService->changeStatus($slider);
        return $this->successResponse(message: __('slider.status_updated_successfully'));
    }
}
