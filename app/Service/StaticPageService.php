<?php

namespace App\Service;

use App\Models\StaticPage\StaticPage;
use App\Http\Requests\Dashboard\StaticPage\StoreStaticPageRequest;
use App\Http\Requests\Dashboard\StaticPage\UpdateStaticPageRequest;

class StaticPageService
{
    public function index($query)
    {
        $staticPageQuery = StaticPage::query()->latest();
        return $query === 'paginate' ? $staticPageQuery->paginate(10) : $staticPageQuery->get();
    }

    public function list(): \Illuminate\Database\Eloquent\Collection
    {
        return StaticPage::query()->latest()->get();
    }

    public function show(StaticPage $staticPage): StaticPage
    {
        return $staticPage;
    }

    public function store(StoreStaticPageRequest $request): StaticPage
    {
        $validatedDate = collect($request->validated())->except('image')->toArray();
        $staticPage = StaticPage::create($validatedDate + ['added_by_id' => auth()->id()]);
        $staticPage->storeImages(media: $request->file('image'), collection: 'staticPage_images');
        return $staticPage;
    }

    public function update(UpdateStaticPageRequest $request, StaticPage $staticPage): StaticPage
    {
        $validatedDate = collect($request->validated())->except('image')->toArray();
        $staticPage->update($validatedDate);
        $staticPage->storeImages(media: $request->file('image'), update: true, collection: 'staticPage_images');
        return $staticPage;
    }

    public function destroy(StaticPage $staticPage): void
    {
        $staticPage->delete();
        $staticPage->clearMediaCollection('staticPage_images');
    }

    public function changeStatus(StaticPage $staticPage): StaticPage
    {
        $staticPage->toggleActivation();
        return $staticPage;
    }
}
