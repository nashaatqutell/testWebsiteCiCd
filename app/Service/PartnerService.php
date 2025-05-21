<?php

namespace App\Service;

use App\Models\Partner\Partner;
use App\Http\Requests\Dashboard\Partner\StorePartnerRequest;
use App\Http\Requests\Dashboard\Partner\UpdatePartnerRequest;

class PartnerService
{
    public function index($query)
    {
        $partnerQuery = Partner::filter()->latest();
        return $query === 'paginate' ? $partnerQuery->paginate(10) : $partnerQuery->get();
    }

    public function list()
    {
        return  Partner::query()->latest()->get();
    }
    public function store(StorePartnerRequest $request)
    {
        $validateData = collect($request->validated())->except('image')->toArray();
        $partner = Partner::create($validateData + ['added_by_id' => auth()->id()]);
        $partner->storeImages(media: $request->file('image'), collection: 'partner_images');
        return $partner;
    }
    public function show(Partner $partner)
    {
        return $partner;
    }

    public function update( UpdatePartnerRequest $request,Partner $partner)
    {
        $validateData = collect($request->validated())->except('image')->toArray();
        $partner->update($validateData);
        $partner->storeImages(media: $request->file('image'), update: true, collection: 'partner_images');
        return $partner;
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();
        $partner->clearMediaCollection('partner_images');
    }

    public function changeStatus(Partner $partner)
    {
        $partner->toggleActivation();
    }

}
