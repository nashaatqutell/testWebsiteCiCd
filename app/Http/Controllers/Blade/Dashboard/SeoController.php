<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Seo\StoreSeoRequest;
use App\Http\Requests\Dashboard\Seo\UpdateSeoRequest;
use App\Models\Seo\Seo;
use App\Service\SeoService;
use Exception;
use Illuminate\Http\Request;

class SeoController extends Controller
{

    private string $viewPath = "dashboard.seo.";
    private string $routePath = "admin.seo";

    public function __construct(protected SeoService $seoService = new SeoService())
    {
        $this->middleware('permission:show_seo')->only(['index','show']);
        $this->middleware('permission:create_seo')->only(['store']);
        $this->middleware('permission:update_seo')->only(['update']);
        $this->middleware('permission:delete_seo')->only(['destroy']);
        $this->middleware('permission:active_seo')->only(['changeStatus']);
    }

    public function index()
    {
        $seos = $this->seoService->index('get');
        return view($this->viewPath . 'index', get_defined_vars());
    }


    public function create()
    {
        return view($this->viewPath . 'single');
    }

    public function store(StoreSeoRequest $request)
    {
        $this->seoService->store($request);
        return $this->webSuccessResponse(route: $this->routePath . '.index', message: __("messages.success"));
    }


    public function show(Seo $seo)
    {
        return view($this->viewPath . 'show', get_defined_vars());
    }


    public function edit(Seo $seo)
    {
        return view($this->viewPath . 'single', get_defined_vars());
    }


    public function update(UpdateSeoRequest $request, Seo $seo)
    {

        $this->seoService->update($request, $seo);
        return $this->webSuccessResponse(route: $this->routePath . '.index', message: __("messages.update"));
    }

    public function destroy(Seo $seo)
    {
        try {
            $this->seoService->destroy($seo);
            return response()->json([
                'success' => true,
                'message' => __('seo.seo_deleted_successfully')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong')
            ], 500);
        }
    }

    public function changeStatus(Seo $seo)
    {
        $this->seoService->changeStatus($seo);

        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated'),
        ]);
    }
}
