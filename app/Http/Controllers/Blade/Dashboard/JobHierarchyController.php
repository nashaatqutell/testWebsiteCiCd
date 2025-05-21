<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\JobsHierarchy\StoreJobHierarchyRequest;
use App\Http\Requests\Dashboard\JobsHierarchy\UpdateJobHierarchyRequest;
use App\Models\JobHierarchy\JobHierarchy;
use App\Service\JobService;
use Exception;

class JobHierarchyController extends Controller
{
    protected $jobService;

    public function __construct()
    {
        $this->jobService = new JobService();
        $this->middleware('permission:show_jobs')->only(['index']);
        $this->middleware('permission:create_jobs')->only(['store']);
        $this->middleware('permission:update_jobs')->only(['update']);
        $this->middleware('permission:delete_jobs')->only(['destroy']);
        $this->middleware('permission:active_jobs')->only(['changeStatus']);
    }

    public function index()
    {
        $jobs = JobHierarchy::whereIsActive()->get();
        $title = __('jobs.Job_Hierarchy');
        return view('dashboard.jobs.index', get_defined_vars());
    }

    public function getChildJob()
    {
        $jobs = JobHierarchy::whereIsActive()->get();
        $title = __('jobs.Job_Hierarchy');
        return view('dashboard.jobs.index', get_defined_vars());
    }

    public function create()
    {
        $job = new JobHierarchy();
        $mainJobs = JobHierarchy::all();
        return view('dashboard.jobs.single', get_defined_vars());
    }

    public function store(StoreJobHierarchyRequest $request)
    {
        $this->jobService->store($request->validated());
        return redirect()->route('admin.jobs.index')->with(
            [
                "message" => __("messages.success"),
                "alert-type" => "success",
            ]
        );
    }

    // edit
    public function edit(JobHierarchy $job)
    {
        $mainJobs = JobHierarchy::where('id', '!=', $job->id)->get();
        return view('dashboard.jobs.single', get_defined_vars());
    }

    public function update(UpdateJobHierarchyRequest $request, JobHierarchy $job)
    {
        $this->jobService->update($request, $job);

        return redirect()->route('admin.jobs.index')->with(
            [
                "message" => __("messages.update"),
                "alert-type" => "success",
            ]
        );
    }

    // destroy
    public function destroy(JobHierarchy $job)
    {
        try {
            $this->jobService->destroy($job);
            return response()->json([
                'success' => true,
                'message' => __('jobs.job_deleted_successfully'),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong'),
            ], 500);
        }
    }

    // changeStatus
    public function changeStatus(JobHierarchy $job)
    {
        $this->jobService->changeStatus($job);
        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated'),
        ]);

    }
}
