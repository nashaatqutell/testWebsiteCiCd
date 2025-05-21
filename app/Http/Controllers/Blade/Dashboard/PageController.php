<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Page\StorePageRequest;
use App\Http\Requests\Dashboard\Page\UpdatePageRequest;
use App\Models\Page\Page;
use App\Models\Service\Service;
use App\Service\PageService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
        $this->middleware('permission:show_pages')->only(['index','show']);
        $this->middleware('permission:create_pages')->only(['store']);
        $this->middleware('permission:update_pages')->only(['update']);
        $this->middleware('permission:delete_pages')->only(['destroy']);
        $this->middleware('permission:active_pages')->only(['changeStatus']);
    }

    public function index()
    {
        $pages = $this->pageService->index('get');
        return view('dashboard.pages.index', get_defined_vars());
    }

    public function create()
    {
        $page = new Page();
        $services = Service::all()->pluck('name', 'id');
        return view('dashboard.pages.single',get_defined_vars());
    }

    public function store(StorePageRequest $request)
    {
        $this->pageService->store($request);
        return redirect()->route('admin.pages.index')->with([
            'message' => __("messages.success"),
            'alert-type' => 'success'
        ]);
    }

    public function edit(Page $page)
    {
        $services = Service::all()->pluck('name', 'id');
        return view('dashboard.pages.single', get_defined_vars());
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        $this->pageService->update($request, $page);
        return redirect()->route('admin.pages.index')->with([
            "message" => __("messages.update"),
            "alert-type" => "success"
        ]);
    }

    public function destroy(Page $page)
    {
        try {
            $this->pageService->destroy($page);
            return response()->json([
                'success' => true,
                'message' => __('pages.pages_deleted_successfully')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong')
            ], 500);
        }
    }

    public function changeStatus(Page $page)
    {
        $this->pageService->changeStatus($page);
        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated')
        ]);
    }
}
