<?php

namespace App\Service;
use App\Http\Requests\Dashboard\Page\StorePageRequest;
use App\Http\Requests\Dashboard\Page\UpdatePageRequest;
use App\Models\Page\Page;

class PageService
{
    public function index($query)
    {
        $pageQuery = Page::with('service')->latest();
        return $query === 'paginate' ? $pageQuery->paginate(10) : $pageQuery->get();
    }

    public function list(): \Illuminate\Database\Eloquent\Collection
    {
        return Page::with('service')->latest()->get();
    }

    public function show(Page $page)
    {
        return $page->load('service');
    }

    public function store(StorePageRequest $request)
    {
        $validatedDate = collect($request->validated())->except('image')->toArray();
        $page = Page::create($validatedDate + ['added_by_id' => auth()->id()]);
        $page->storeImages(media: $request->file('image'), collection: 'Page_images');
        return $page;
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        $validatedDate = collect($request->validated())->except('image')->toArray();
        $page->update($validatedDate);
        $page->storeImages(media: $request->file('image'), update: true, collection: 'Page_images');
        return $page;
    }

    public function destroy(Page $page): void
    {
        $page->delete();
        $page->clearMediaCollection('Page_images');
    }

    public function changeStatus(Page $page)
    {
        $page->toggleActivation();
        return $page;
    }
}
