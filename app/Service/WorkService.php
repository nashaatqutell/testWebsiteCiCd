<?php

namespace App\Service;

use App\Models\Work\Work;
use App\Http\Requests\Dashboard\Work\StoreWorkRequest;
use App\Http\Requests\Dashboard\Work\UpdateWorkRequest;

class WorkService
{
    public function index($query)
    {
        $workQuery = Work::query()->latest();
        return $query === 'paginate' ? $workQuery->paginate(10) : $workQuery->get();
    }

    public function list():\Illuminate\Database\Eloquent\Collection
    {
        return Work::query()->latest()->get();
    }

    public function show(Work $work) : Work
    {
        return $work;
    }

    public function store(StoreWorkRequest $request) : Work
    {
        $validateData = collect($request->validated())->except(['images', 'video'])->toArray();
        $work = Work::create($validateData + ['added_by_id' => auth()->id()]);

        $work->storeImages(media: $request->file('images'), collection: 'work_images');

        $work->storeVideos(media: $request->file('video'), collection: 'work_videos');

        return $work;
    }

    public function update(UpdateWorkRequest $request, Work $work) : Work
    {
        $validatedDate = collect($request->validated())->except(['images', 'video'])->toArray();
        $work->update($validatedDate);

        $work->storeImages(media: $request->file('images'), update: true, collection: 'work_images');

        $work->storeVideos(media: $request->file('video'), update: true, collection: 'work_videos');
        return $work;
    }

    public function destroy(Work $work) : void
    {
        $work->delete();
        $work->clearMediaCollection('work_images');
        $work->clearMediaCollection('work_videos');
    }

    public function changeStatus(Work $work)
    {
        $work->toggleActivation();
    }
}
