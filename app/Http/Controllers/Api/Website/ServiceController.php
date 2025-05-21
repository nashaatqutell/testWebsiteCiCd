<?php
namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\ServiceWebsiteRescource;
use App\Http\Resources\ServiceWithChildrenByIdResource;
use App\Http\Resources\ServiceWithChildrenResource;
use App\Models\Service\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $parentService = Service::whereNull('parent_id')->pluck('id')->toArray();
        $services = Service::whereIsActive()
            ->whereIn('parent_id',$parentService)
            ->where('show',True)
            ->get();
        return $this->successResponse(ServiceWebsiteRescource::collection($services));
    }
    public function getMainServices(Request $request)
    {
        $services = Service::whereIsActive()
            ->whereNull('parent_id')
            ->get();
        return $this->successResponse(ServiceResource::collection($services));
    }
    public function getServicesWithChild(Request $request)
    {
        $services = Service::whereIsActive()
            ->whereNull('parent_id')
            ->with('children')
            ->get();

        return $this->successResponse(ServiceWithChildrenResource::collection($services));
    }
    public function getServiceById(Service $service)
    {
        $service->load('children.children');
        return $this->successResponse(ServiceWithChildrenByIdResource::make($service));
    }

}
