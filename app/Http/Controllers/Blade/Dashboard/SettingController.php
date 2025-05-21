<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Setting\StoreSettingRequest;
use App\Models\Setting\Setting;
use App\Service\SettingService;

class SettingController extends Controller
{

    private string $routePath = 'admin.settings';
    private string $viewPath = 'dashboard.settings';

    public function __construct(protected SettingService $blogService = new SettingService())
    {
        $this->middleware('permission:show_settings')->only(['index', 'show']);
        $this->middleware('permission:create_settings')->only(['store']);
        $this->middleware('permission:update_settings')->only(['update']);
        $this->middleware('permission:delete_settings')->only(['destroy']);
        $this->middleware('permission:active_settings')->only(['changeStatus']);
    }

    public function edit(Setting $setting)
    {
        $fields = ['email' => 'email', 'whatsapp' => 'text', 'phone' => 'text', 'phone2' => 'text','support_phone' => 'text' ,'location' => 'text','embed_map' => 'text',
            'facebook' => 'text', 'x' => 'text', 'instagram' => 'text', 'youtube' => 'text', 'tiktok' => 'text'
        ];
        return view($this->viewPath . '.single', get_defined_vars());
    }

    public function update(StoreSettingRequest $request, Setting $setting)
    {

        $setting = $this->blogService->update($request, $setting);

        return $this->webDataResponse(
            route: $this->routePath . '.edit',
            data: get_defined_vars(),
            message: __("messages.update")
        );
    }
}
