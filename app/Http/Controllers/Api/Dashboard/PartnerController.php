<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Partner\StorePartnerRequest;
use App\Http\Requests\Dashboard\Partner\UpdatePartnerRequest;
use App\Http\Resources\PartnerResource;
use App\Http\Resources\SimpleDataResource;
use App\Models\Partner\Partner;
use App\Service\PartnerService;

class PartnerController extends Controller
{
    protected $partnerService;

    public function __construct(PartnerService $partnerService)
    {
        $this->partnerService = $partnerService;
        $this->middleware('permission:show_partners')->only(['index', 'show']);
        $this->middleware('permission:create_partners')->only(['store']);
        $this->middleware('permission:update_partners')->only(['update']);
        $this->middleware('permission:delete_partners')->only(['destroy']);
        $this->middleware('permission:active_partners')->only(['changeStatus']);
    }

    public function index()
    {
        $partners = $this->partnerService->index('paginate');
        return $this->paginateResponse(PartnerResource::collection($partners), $partners);
    }

    public function list()
    {
        $partners = $this->partnerService->list();
        return $this->successResponse(SimpleDataResource::collection($partners), __('partner.retrieved_successfully'));
    }

    public function store(StorePartnerRequest $request)
    {
        $partner = $this->partnerService->store($request);
        return $this->successResponse(data: $partner->getResource(), message: __('partner.created_successfully'));
    }

    public function show(Partner $partner)
    {
        $partner = $this->partnerService->show($partner);
        return $this->successResponse(PartnerResource::make($partner), __('partner.retrieved_successfully'));
    }

    public function update(UpdatePartnerRequest $request, Partner $partner)
    {
        $partner = $this->partnerService->update($request, $partner);
        return $this->successResponse(data: $partner->getResource(), message: __('partner.updated_successfully'));
    }

    public function destroy(Partner $partner)
    {
        $this->partnerService->destroy($partner);
        return $this->successResponse(null, __('partner.deleted_successfully'));
    }

    public function changeStatus(Partner $partner)
    {
        $this->partnerService->changeStatus($partner);
        return $this->successResponse(message: __('partner.status_updated_successfully'));
    }
}
