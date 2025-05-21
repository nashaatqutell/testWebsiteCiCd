<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\Setting\Setting;

class SettingController extends Controller
{

    public function __invoke()
    {
        $settings = Setting::query()->latest()->whereIsActive()->with("media")->first();
        return $this->successResponse(SettingResource::make($settings),message: __("messages.fetched_successfully"));
    }
}
