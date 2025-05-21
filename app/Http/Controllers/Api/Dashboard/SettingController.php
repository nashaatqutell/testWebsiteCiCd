<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Setting\StoreSettingRequest;
use App\Http\Resources\SettingResource;
use App\Models\Setting\Setting;
use App\Service\SettingService;

class SettingController extends Controller
{
    public function __construct(protected SettingService $settingService = new SettingService())
    {
        $this->middleware('permission:show_settings')->only(['index']);
        $this->middleware('permission:update_settings')->only(['update']);
    }

    public function index()
    {
        $settings = $this->settingService->index('paginate');

        return $this->paginateResponse(
            data: SettingResource::collection($settings),
            collection: $settings
        );
    }

    public function update(StoreSettingRequest $request, Setting $setting)
    {
        $setting = $this->settingService->update($request, $setting);
        return $this->successResponse(data: $setting->getResource(), message: __("messages.update"));
    }
}
