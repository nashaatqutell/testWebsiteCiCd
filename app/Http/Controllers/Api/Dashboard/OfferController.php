<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Offer\StoreOfferRequest;
use App\Http\Requests\Dashboard\Offer\UpdateOfferRequest;
use App\Http\Resources\OfferResource;
use App\Http\Resources\SimpleDataResource;
use App\Models\Offer\Offer;
use App\Service\OfferService;

class OfferController extends Controller
{
    public function __construct(protected OfferService $offerService = new OfferService())
    {
        $this->middleware('permission:show_offers')->only(['index','show']);
        $this->middleware('permission:create_offers')->only(['store']);
        $this->middleware('permission:update_offers')->only(['update']);
        $this->middleware('permission:delete_offers')->only(['destroy']);
        $this->middleware('permission:active_offers')->only(['changeStatus']);
    }

    public function index()
    {
        $offers = $this->offerService->index('paginate');
        return $this->paginateResponse(data: OfferResource::collection($offers),collection: $offers);
    }

    public function list()
    {
        $offers = $this->offerService->list();
        return $this->successResponse(data: SimpleDataResource::collection($offers),message: __("messages.fetched_successfully"));
    }

    public function show(Offer $offer)
    {
        return $this->successResponse(data: OfferResource::make($offer),message: __("messages.fetched_successfully"));
    }

    public function store(StoreOfferRequest $request)
    {
        $offer = $this->offerService->store($request);
        return $this->successResponse(data: $offer->getResource(), message: __("messages.success"));
    }

    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        $offer = $this->offerService->update($request, $offer);
        return $this->successResponse(data: $offer->getResource(), message: __("messages.success"));
    }

    public function destroy(Offer $offer)
    {
        $this->offerService->destroy($offer);
        return $this->successResponse(message: __("messages.delete"));
    }

    public function changeStatus(Offer $offer)
    {
        $offer = $this->offerService->changeStatus($offer);
        return $this->successResponse(data: $offer->getResource(), message: __("messages.success"));
    }
}
