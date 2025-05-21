<?php

namespace App\Service;

use App\Models\About\About;

class AboutService
{
    public function getAllAbouts($query)
    {
        $aboutsQuery = About::query()->latest();
        return $query === 'paginate' ? $aboutsQuery->paginate(10) : $aboutsQuery->get();
    }

    public function getAboutByType($type)
    {
        return About::query()->whereType($type)->latest()->get();
    }

    public function listAbouts()
    {
        return About::latest()->get();
    }

    public function storeAbout($data)
    {
        $about = About::create($data + ['added_by_id' => auth()->user()->id]);

        if (isset($data['image'])) {
            $about->storeImages(media: $data['image'], collection: 'about_images');
        }
        if (isset($data['org_structure'])) {
            $about->storeImages(media: $data['org_structure'], collection: 'org_structure');
        }

        if (isset($data['org_structure_ar'])) {
            $about->storeImages(media: $data['org_structure_ar'], collection: 'org_structure_ar');
        }

        return $about;
    }

    public function updateAbout(About $about, $data)
    {
        $about->update($data);

        if (isset($data['image'])) {
            $about->storeImages(media: $data['image'], update: true, collection: 'about_images');
        }

        if (isset($data['org_structure'])) {
            $about->storeImages(media: $data['org_structure'], update: true, collection: 'org_structure');
        }

        if (isset($data['org_structure_ar'])) {
            $about->storeImages(media: $data['org_structure_ar'], update: true, collection: 'org_structure_ar');
        }

        return $about;
    }

    public function deleteAbout(About $about)
    {
        $about->delete();
        $about->clearMediaCollection('about_images');
    }

    public function toggleAboutStatus(About $about)
    {
        $about->toggleActivation();
    }

}
