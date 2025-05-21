<?php

namespace App\Service;

use App\Models\Gallery\Gallery;
use App\Http\Requests\Dashboard\Gallery\StoreGalleryRequest;
use App\Http\Requests\Dashboard\Gallery\UpdateGalleryRequest;

class GalleryService
{
    public function index($query)
    {
        $galleryQuery = Gallery::query()->latest();
        return   $query === 'paginate' ? $galleryQuery->paginate(10) : $galleryQuery->get();
    }

    public function list():\Illuminate\Database\Eloquent\Collection
    {
        return Gallery::query()->latest()->get();
    }

    public function show(Gallery $Gallery) : Gallery
    {
        return $Gallery;
    }

    public function store(StoreGalleryRequest $request) : Gallery
    {
        $Gallery = Gallery::query()->create($request->validated());
        $Gallery->storeImages(media: $request->images);
        return $Gallery;
    }

    public function update(UpdateGalleryRequest $request, Gallery $Gallery) : Gallery
    {
        $Gallery->update($request->validated());
        $Gallery->storeImages(media: $request->images, update: true);
        return $Gallery;
    }

    public function destroy(Gallery $Gallery) : void
    {
        $Gallery->deleteMedia();
        $Gallery->delete();
    }

    public function changeStatus(Gallery $Gallery) : Gallery
    {
        $Gallery->toggleActivation();
        return $Gallery;
    }
}
