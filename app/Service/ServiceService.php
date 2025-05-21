<?php

namespace App\Service;

use App\Models\Service\Service;
use App\Http\Requests\Dashboard\Services\UpdateServiceRequest;
use App\Http\Requests\Dashboard\Services\StoreServiceRequest;

class ServiceService
{
    public function index($query)
    {
        $servicesQuery = Service::query()->latest();
        return $query === 'paginate' ? $servicesQuery->paginate(10) : $servicesQuery->get();
    }

    public function list(): \Illuminate\Database\Eloquent\Collection
    {
        return Service::query()->latest()->get();
    }

    public function show(Service $service): Service
    {
        return $service;
    }

    public function store(StoreServiceRequest $request): Service
    {
        $validateData = collect($request->validated())->except(['images', 'video'])->toArray();
        $service = Service::create($validateData + ['added_by_id' => auth()->id()]);

        $service->storeImages(media: $request->file('images'), collection: 'service_images');

        $service->storeVideos(media: $request->file('video'), collection: 'service_videos');
        return $service;
    }

    public function update(UpdateServiceRequest $request, Service $service): Service
    {
        $validateData = collect($request->validated())->except(['images', 'video'])->toArray();

        $service->update($validateData);
        $service->storeImages(media: $request->file('images'), update: true, collection: 'service_images');
        $service->storeVideos(media: $request->file('video'), update: true, collection: 'service_videos');
        return $service;
    }

    public function destroy(Service $service): void
    {
        $service->delete();
        $service->clearMediaCollection('service_images');
        $service->clearMediaCollection('service_video');
    }

    public function changeStatus(Service $service): Service
    {
        $service->toggleActivation();
        return $service;
    }
    public function changeStatusFront(Service $service): Service
    {
        $service->toggleStatus();
        return $service;
    }
}
