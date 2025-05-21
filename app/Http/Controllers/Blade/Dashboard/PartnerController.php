<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Partner\StorePartnerRequest;
use App\Http\Requests\Dashboard\Partner\UpdatePartnerRequest;
use App\Models\Partner\Partner;
use App\Service\PartnerService;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    protected $partnerService;

    public function  __construct(PartnerService $partnerService)
    {
        $this->partnerService = $partnerService;
        $this->middleware('permission:show_partners')->only(['index','show']);
        $this->middleware('permission:create_partners')->only(['store']);
        $this->middleware('permission:update_partners')->only(['update']);
        $this->middleware('permission:delete_partners')->only(['destroy']);
        $this->middleware('permission:active_partners')->only(['changeStatus']);
    }

    public function index()
    {
        $partners = $this->partnerService->index('get');
        return view('dashboard.partners.index',get_defined_vars());
    }


    public function create()
    {
        $partner = new Partner();
        return view('dashboard.partners.single',get_defined_vars());
    }

    public function store(StorePartnerRequest $request)
    {

        $this->partnerService->store($request);
        return redirect()->route('admin.partners.index')->with(array(
            'message' => __("messages.success"),
            'alert-type' => 'success'
        ));
    }

    public function edit(Partner $partner)
    {
        return view('dashboard.partners.single',get_defined_vars());
    }

    public function update(UpdatePartnerRequest $request, Partner  $partner)
    {
        $this->partnerService->update($request, $partner);
        return redirect()->route('admin.partners.index')->with(
            array(
                "message" => __("messages.update"),
                "alert-type" => "success"
            )
        );
    }

    public function destroy(Partner $partner)
    {
        try {
            $this->partnerService->destroy($partner);
            return response()->json([
                'success' => true,
                'message' => __('partner.partners_deleted_successfully')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong')
            ], 500);
        }

    }
    public function changeStatus(Partner $partner)
    {
        $this->partnerService->changeStatus($partner);
        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated')
        ]);
    }
}
