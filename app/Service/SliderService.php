<?php

namespace App\Service;

use App\Models\Slider\Slider;
use App\Http\Requests\Dashboard\Slider\StoreSliderRequest;
use App\Http\Requests\Dashboard\Slider\UpdateSliderRequest;

class SliderService
{
    public function index($query)
    {
        $sliderQuery = Slider::query()->latest();
        return $query === 'paginate' ? $sliderQuery->paginate(10) : $sliderQuery->get();
    }

    public function list():\Illuminate\Database\Eloquent\Collection
    {
        return Slider::query()->latest()->get();
    }

    public function show(Slider $slider) : Slider
    {
        return $slider;
    }

    public function store(StoreSliderRequest $request) : Slider
    {
        $validatedDate = collect($request->validated())->except('image')->toArray();
        $slider = Slider::create($validatedDate + ['added_by_id' => auth()->id()]);

        $slider->storeImages(media:$request->file('image'),collection: 'slider_images');
        return $slider;
    }

    public function update(UpdateSliderRequest $request, Slider $slider) : Slider
    {
        $validatedDate = collect($request->validated())->except('image')->toArray();
        $slider->update($validatedDate);
        $slider->storeImages(media: $request->file('image'),update: true,collection: "slider_images");
        return $slider;
    }

    public function destroy(Slider $slider) : void
    {
        $slider->delete();
        $slider->clearMediaCollection('slider_images');
    }

    public function changeStatus(Slider $slider) : Slider
    {
        $slider->toggleActivation();
        return $slider;
    }
}
