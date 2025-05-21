<?php
namespace App\Service;

use App\Http\Requests\Dashboard\JobsHierarchy\UpdateJobHierarchyRequest;
use App\Models\JobHierarchy\JobHierarchy;

class JobService
{
    public function index($query)
    {
        $jobs = JobHierarchy::query()->latest();
        return $query === 'paginate' ? $jobs->paginate(10) : $jobs->get();
    }

    public function list(): \Illuminate\Database\Eloquent\Collection
    {
        return JobHierarchy::query()->latest()->get();
    }

    public function show(JobHierarchy $job): JobHierarchy
    {
        return $job;
    }

    public function store($data)
    {
        $job = JobHierarchy::create($data + ['added_by_id' => auth()->user()->id]);
        $job->storeImages(media: $data['image'], collection: 'job_images');
        return $job;

    }

    public function update(UpdateJobHierarchyRequest $request, JobHierarchy $job): JobHierarchy
    {
        $validateData = collect($request->validated())->except(['image'])->toArray();
        $job->update($validateData);
        $job->storeImages(media: $request->file('image'), update: true, collection: 'job_images');
        return $job;
    }

    public function destroy(JobHierarchy $job): void
    {
        $job->delete();
        $job->clearMediaCollection('job_images');
    }

    public function changeStatus(JobHierarchy $job): JobHierarchy
    {
        $job->toggleActivation();
        return $job;
    }
}
