<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Services\StoreServiceRequest;
use App\Http\Requests\Dashboard\Services\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\SimpleDataResource;
use App\Models\Service\Service;
use App\Service\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
        $this->middleware('permission:show_services')->only(['index', 'show']);
        $this->middleware('permission:create_services')->only(['store']);
        $this->middleware('permission:update_services')->only(['update']);
        $this->middleware('permission:delete_services')->only(['destroy']);
        $this->middleware('permission:active_services')->only(['changeStatus']);
    }

    public function index()
    {
        $services = $this->serviceService->index('paginate');
        return $this->paginateResponse(ServiceResource::collection($services), $services);
    }

    public function list()
    {
        $services = $this->serviceService->list();
        return $this->successResponse(SimpleDataResource::collection($services), __('service.retrieved_successfully'));
    }

    public function store(StoreServiceRequest $request)
    {
        $service = $this->serviceService->store($request);
        return $this->successResponse(data: $service->getResource(), message: __('service.created_successfully'));
    }

    public function show(Service $service)
    {
        $service = $this->serviceService->show($service);
        return $this->successResponse(ServiceResource::make($service), __('service.retrieved_successfully'));
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service = $this->serviceService->update($request, $service);
        return $this->successResponse(data: $service->getResource(), message: __('service.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $this->serviceService->destroy($service);
        return $this->successResponse(null, __('service.deleted_successfully'));
    }

    public function changeStatus(Service $service)
    {
        $this->serviceService->changeStatus($service);
        return $this->successResponse(message: __('service.status_updated_successfully'));
    }
}
