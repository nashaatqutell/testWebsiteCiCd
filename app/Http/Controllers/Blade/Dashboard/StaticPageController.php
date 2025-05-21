<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StaticPage\StoreStaticPageRequest;
use App\Http\Requests\Dashboard\StaticPage\UpdateStaticPageRequest;
use App\Http\Resources\StaticPageResource;
use App\Models\StaticPage\StaticPage;
use App\Service\StaticPageService;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    protected $staicPageService;

    public function  __construct(StaticPageService $staicPageService)
    {
          $this->staicPageService = $staicPageService;
        $this->middleware('permission:show_staticPages')->only(['index','show']);
        $this->middleware('permission:create_staticPages')->only(['store']);
        $this->middleware('permission:update_staticPages')->only(['update']);
        $this->middleware('permission:delete_staticPages')->only(['destroy']);
        $this->middleware('permission:active_staticPages')->only(['changeStatus']);
    }

    public function index()
    {
        $staticpages = $this->staicPageService->index('get');
        return view('dashboard.staticPages.index',get_defined_vars());
    }


    public function create()
    {
        $staticPage = new StaticPage();
        return view('dashboard.staticPages.single',get_defined_vars());
    }

    public function store(StoreStaticPageRequest $request)
    {

        $this->staicPageService->store($request);
        return redirect()->route('admin.static_pages.index')->with(array(
            'message' => __("messages.success"),
            'alert-type' => 'success'
        ));
    }

    public function edit(StaticPage $staticPage)
    {
        return view('dashboard.staticPages.single',get_defined_vars());
    }


    public function update(UpdateStaticPageRequest $request, StaticPage  $staticPage)
    {
        $this->staicPageService->update($request, $staticPage);
        return redirect()->route('admin.static_pages.index')->with(
            array(
                "message" => __("messages.update"),
                "alert-type" => "success"
            )
        );
    }
    public function destroy(StaticPage $staticPage)
    {
        try {
            $this->staicPageService->destroy($staticPage);
            return response()->json([
                'success' => true,
                'message' => __('staticpage.staticpages_deleted_successfully')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong')
            ], 500);
        }

    }
    public function changeStatus(StaticPage $staticPage)
    {
        $this->staicPageService->changeStatus($staticPage);
        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated')
        ]);
    }
}
