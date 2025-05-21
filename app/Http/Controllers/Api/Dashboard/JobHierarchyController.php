<?php
namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\JobsHierarchy\StoreJobHierarchyRequest;
use App\Http\Requests\Dashboard\JobsHierarchy\UpdateJobHierarchyRequest;
use App\Http\Resources\JobResource;
use App\Http\Resources\JobWebsiteRescource;
use App\Models\JobHierarchy\JobHierarchy;
use App\Service\JobService;

class JobHierarchyController extends Controller
{
    protected $jobService;

    public function __construct()
    {
        $this->jobService = new JobService();
        $this->middleware('permission:show_jobs')->only(['index','show']);
        $this->middleware('permission:create_jobs')->only(['store']);
        $this->middleware('permission:update_jobs')->only(['update']);
        $this->middleware('permission:delete_jobs')->only(['destroy']);
        $this->middleware('permission:active_jobs')->only(['changeStatus']);
    }

    public function index()
    {
        $jobs = $this->jobService->index('paginate');
        return $this->paginateResponse(JobResource::collection($jobs), $jobs);
    }

    public function list()
    {
        $jobs = $this->jobService->list();
        return $this->successResponse(JobWebsiteRescource::collection($jobs), __('messages.retrieved_successfully'));
    }

    public function show(JobHierarchy $job)
    {
        $job = $this->jobService->show($job);
        return $this->successResponse(JobResource::make($job), __('messages.retrieved_successfully'));
    }

    public function store(StoreJobHierarchyRequest $request)
    {
        $job = $this->jobService->store($request->validated());
        return $this->successResponse(data: $job->getResource(), message: __('messages.success'));
    }

    public function update(UpdateJobHierarchyRequest $request, JobHierarchy $job)
    {
        $job = $this->jobService->update($request, $job);

        return $this->successResponse(data: $job->getResource(), message: __('messages.update'));
    }

    public function destroy(JobHierarchy $job)
    {
        $this->jobService->destroy($job);
        return $this->successResponse(message: __('messages.delete'));
    }

    public function changeStatus(JobHierarchy $job)
    {
        $this->jobService->changeStatus($job);
        return $this->successResponse(message: __('messages.update'));
    }

}
