<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Gallery\StoreGalleryRequest;
use App\Http\Requests\Dashboard\Gallery\UpdateGalleryRequest;
use App\Models\Gallery\Gallery;
use App\Service\GalleryService;
use Exception;
use Illuminate\Http\Request;

class GalleryController extends Controller
{

    private string $routePath = 'admin.galleries';
    private string $viewPath = 'dashboard.gallery';

    public function __construct(protected GalleryService $GalleryService = new GalleryService())
    {
        $this->middleware('permission:show_galleries')->only(['index','show']);
        $this->middleware('permission:create_galleries')->only(['store']);
        $this->middleware('permission:update_galleries')->only(['update']);
        $this->middleware('permission:delete_galleries')->only(['destroy']);
        $this->middleware('permission:active_galleries')->only(['changeStatus']);
    }


    public function index()
    {
        $Galleries = $this->GalleryService->index('get');
        return view($this->viewPath . '.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->viewPath . '.single');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGalleryRequest $request)
    {
        $Gallery = $this->GalleryService->store($request);
        return $this->webSuccessResponse(route: $this->routePath . '.index', message: __("messages.success"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $Gallery)
    {
        return view($this->viewPath . '.single', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGalleryRequest $request, Gallery $Gallery)
    {
        $Gallery = $this->GalleryService->update($request, $Gallery);
        return $this->webSuccessResponse(route: $this->routePath . '.index', message: __("messages.update"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $Gallery)
    {
        try {
            $this->GalleryService->destroy($Gallery);
            return response()->json([
                'success' => true,
                'message' => __('Keys.deleted')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong')
            ], 500);
        }

    }

    public function changeStatus(Gallery $Gallery)
    {
        $this->GalleryService->changeStatus($Gallery);
        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated'),
        ]);
    }
}
