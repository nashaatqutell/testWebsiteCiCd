<?php
namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Services\StoreServiceRequest;
use App\Http\Requests\Dashboard\Services\UpdateServiceRequest;
use App\Models\Service\Service;
use App\Service\ServiceService;
use Exception;
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

    // Get Main Service
    public function index()
    {
        $services = Service::whereNull('parent_id')
            ->latest()
            ->get();
        $title = __('service.parentServices');
        return view('dashboard.services.index', get_defined_vars());
    }
    // GET Child Services Without Parent
    public function getChildService()
    {
        $services = Service::whereNotNull('parent_id')
            ->latest()
            ->get();
        $title = __('service.childServices');
        return view('dashboard.services.index', get_defined_vars());

    }

    public function create()
    {
        $service        = new Service();
        $parentServices = Service::all();
        return view('dashboard.services.single', get_defined_vars());
    }

    public function store(StoreServiceRequest $request)
    {
        $this->serviceService->store($request);
        return redirect()->route('admin.services.index')->with(
            [
                "message"    => __("messages.success"),
                "alert-type" => "success",
            ]
        );
    }

    public function edit(Service $service)
    {
        $parentServices = Service::where('id', '!=', $service->id)->get(); // Exclude current service
        return view('dashboard.services.single', get_defined_vars());
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $this->serviceService->update($request, $service);
        return redirect()->route('admin.services.index')->with(
            [
                "message"    => __("messages.update"),
                "alert-type" => "success",
            ]
        );
    }

    public function destroy(Service $service)
    {
        try {
            $this->serviceService->destroy($service);
            return response()->json([
                'success' => true,
                'message' => __('service.services_deleted_successfully'),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong'),
            ], 500);
        }
    }

    public function changeStatus(Service $service)
    {
        $this->serviceService->changeStatus($service);
        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated'),
        ]);
    }

    public function changeStatusFront(Service $service)
    {
        $this->serviceService->changeStatusFront($service);
        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated'),
        ]);
    }
    public function changeOrder(Request $request, Service $service)
    {
        $service->update(['order' => $request->order]);
        return response()->json(['success' => true, 'message' => __('service.order_updated_successfully')]);
    }
}
