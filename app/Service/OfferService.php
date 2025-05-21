<?php

namespace App\Service;

use App\Models\Offer\Offer;
use App\Http\Requests\Dashboard\Offer\StoreOfferRequest;
use App\Http\Requests\Dashboard\Offer\UpdateOfferRequest;

class OfferService
{
    public function index($query)
    {
        $offerQuery = Offer::query()->latest();
        return $query === 'paginate' ? $offerQuery->paginate(10) : $offerQuery->get();

    }

    public function list():\Illuminate\Database\Eloquent\Collection
    {
        return Offer::query()->latest()->get();
    }

    public function show(Offer $Offer) : Offer
    {
        return $Offer;
    }

    public function store(StoreOfferRequest $request) : Offer
    {
        return Offer::query()->create($request->validated() + ["added_by_id" => auth()->user()->id]);
    }

    public function update(UpdateOfferRequest $request, Offer $Offer) : Offer
    {
        $Offer->update($request->validated() + ["added_by_id" => auth()->user()->id]);
        return $Offer;
    }

    public function destroy(Offer $Offer) : void
    {
        $Offer->delete();
    }

    public function changeStatus(Offer $Offer) : Offer
    {
        $Offer->toggleActivation();
        return $Offer;
    }
}
