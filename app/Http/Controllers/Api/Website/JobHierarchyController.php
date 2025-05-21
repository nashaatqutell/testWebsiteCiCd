<?php
namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobWebsiteResource;
use App\Models\JobHierarchy\JobHierarchy;

class JobHierarchyController extends Controller
{
    public function index()
    {
        $jobs = JobHierarchy::whereIsActive()->get();
        return $this->successResponse(JobWebsiteResource::collection($jobs));
    }
    public function show($id)
    {
        $job = JobHierarchy::whereIsActive()->findOrFail($id);
        return $this->successResponse(JobWebsiteResource::make($job));
    }

}
