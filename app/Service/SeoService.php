<?php

namespace App\Service;

use App\Models\Seo\Seo;
use App\Http\Requests\Dashboard\Seo\StoreSeoRequest;
use App\Http\Requests\Dashboard\Seo\UpdateSeoRequest;

class SeoService
{
    public function index($query)
    {
        $seoQuery = Seo::query()->latest();
        return $query === 'paginate' ? $seoQuery->paginate(10) : $seoQuery->get();
    }

    public function list():\Illuminate\Database\Eloquent\Collection
    {
        return Seo::query()->latest()->get();
    }

    public function show(Seo $Seo) : Seo
    {
        return $Seo;
    }

    public function store(StoreSeoRequest $request) : Seo
    {
        return Seo::query()->create($request->validated() + ["added_by_id" => auth()->id()]);
    }

    public function update(UpdateSeoRequest $request, Seo $Seo) : Seo
    {
        $Seo->update($request->validated() + ["added_by_id" => auth()->id()]);
        return $Seo;
    }

    public function destroy(Seo $Seo) : void
    {
        $Seo->delete();
    }

    public function changeStatus(Seo $Seo) : Seo
    {
        $Seo->toggleActivation();
        return $Seo;
    }
}
