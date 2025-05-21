<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Work\StoreWorkRequest;
use App\Http\Requests\Dashboard\Work\UpdateWorkRequest;
use App\Http\Resources\SimpleDataResource;
use App\Http\Resources\WorkResource;
use App\Models\Work\Work;
use App\Service\WorkService;

class WorkController extends Controller
{
    protected $workService;
    public function __construct(WorkService $workService)
    {
        $this->workService = $workService;
        $this->middleware('permission:show_works')->only(['index', 'show']);
        $this->middleware('permission:create_works')->only(['store']);
        $this->middleware('permission:update_works')->only(['update']);
        $this->middleware('permission:delete_works')->only(['destroy']);
        $this->middleware('permission:active_works')->only(['changeStatus']);
    }

    public function index()
    {
        $works = $this->workService->index('paginate');
        return $this->paginateResponse(WorkResource::collection($works), $works);
    }

    public function list()
    {
        $works = $this->workService->list();

        return $this->successResponse(SimpleDataResource::collection($works), __('work.retrieved_successfully'));
    }

    public function store(StoreWorkRequest $request)
    {
        $work = $this->workService->store($request);
        return $this->successResponse(data: $work->getResource(), message: __('work.created_successfully'));
    }

    public function show(Work $work)
    {
        $this->workService->show($work);
        return $this->successResponse(WorkResource::make($work), __('work.retrieved_successfully'));
    }

    public function update(UpdateWorkRequest $request, Work $work)
    {
        $work = $this->workService->update($request, $work);
        return $this->successResponse(data: $work->getResource(), message: __('work.updated_successfully'));
    }


    public function destroy(Work $work)
    {
        $this->workService->destroy($work);
        return $this->successResponse(null, __('work.deleted_successfully'));
    }

    public function changeStatus(Work $work)
    {
        $this->workService->changeStatus($work);
        return $this->successResponse(message: __('work.status_updated_successfully'));
    }
}
