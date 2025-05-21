<?php

namespace App\Service;

use App\Models\Setting\Setting;
use App\Http\Requests\Dashboard\Setting\StoreSettingRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SettingService
{
    public function index($query)
    {
        $settingQuery = Setting::query()->latest();
        return $query === 'paginate' ? $settingQuery->paginate(10) : $settingQuery->get();
    }


    public function update(StoreSettingRequest $request, Setting $Setting): Setting
    {
        $Setting->update($request->validated() + ["added_by_id" => auth()->id()]);
        $Setting->storeImages(media: $request->logo, update: true,collection: "logo");
        $Setting->storeImages(media: $request->logo2,update: true,collection: "logo2");
        $Setting->storeImages(media: $request->footer_image,update: true,collection: "footer_image");
        $Setting->storeImages(media: $request->financial_menus_image,update: true,collection: "financial_menus_image");
        $Setting->storeImages(media: $request->favicon, update: true,collection: "favicon");
        return $Setting;
    }
}
