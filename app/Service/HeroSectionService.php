<?php

namespace App\Service;

use App\Models\HeroSection\HeroSection;
use App\Http\Requests\Dashboard\HeroSection\UpdateHeroSectionRequest;

class  HeroSectionService
{
    public function index($query)
    {
        $heroSectionQuery = HeroSection::latest();
        return  $query === 'paginate' ? $heroSectionQuery->paginate(10) : $heroSectionQuery->get();
    }
    public function update(UpdateHeroSectionRequest $request, HeroSection $heroSection)
    {
        $validatedDate = collect($request->validated())->except(['image', 'video'])->toArray();
        $heroSection->update($validatedDate);

        $heroSection->storeImages(media: $request->file('image'), update: true, collection: 'heroSection_images');

        $heroSection->storeVideos(media: $request->file('video'), update: true, collection: 'heroSection_videos');


        return $heroSection;
    }
}
