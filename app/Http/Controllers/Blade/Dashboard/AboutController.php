<?php

namespace App\Http\Controllers\Blade\Dashboard;

use Illuminate\Http\Request;
use App\Service\AboutService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\About\StoreAboutRequest;
use App\Http\Requests\Dashboard\About\UpdateAboutRequest;
use App\Models\About\About;
use Exception;


class AboutController extends Controller
{
    protected $aboutService;

    public function __construct(AboutService $aboutService)
    {
         $this->middleware('permission:show_abouts')->only(['index','show']);
         $this->middleware('permission:create_abouts')->only(['store']);
         $this->middleware('permission:update_abouts')->only(['update']);
         $this->middleware('permission:delete_abouts')->only(['destroy']);
         $this->middleware('permission:active_abouts')->only(['changeStatus']);

        $this->aboutService = $aboutService;
    }

    public function index()
    {
        $abouts = $this->aboutService->getAllAbouts('get');
        return view('dashboard.about.index', get_defined_vars());
    }

    public function fetch_abouts()
    {
        $type = request()->type;
        $abouts = $this->aboutService->getAboutByType($type);
        return view('dashboard.about.index', get_defined_vars());
    }


    public function create()
    {
        $type = request()->type;
        return view('dashboard.about.single', get_defined_vars());
    }


    public function store(StoreAboutRequest $request)
    {
        $this->aboutService->storeAbout($request->validated());

        return to_route('admin.abouts.fetch_abouts', ['type' => $request->type])->with(array(
            'message' => __("messages.success"),
            'alert-type' => 'success'
        ));
    }


    public function edit(About $about)
    {
        $type = request()->type;
        return view('dashboard.about.single', get_defined_vars());
    }

    public function update(UpdateAboutRequest $request, About $about)
    {
        $about = $this->aboutService->updateAbout($about, $request->validated());

        return to_route('admin.abouts.fetch_abouts', ['type' => $request->type])->with(
            array(
                "message" => __("messages.update"),
                "alert-type" => "success"
            )
        );
    }

    public function destroy(About $about)
    {
        try {
            $this->aboutService->deleteAbout($about);
            return response()->json([
                'success' => true,
                'message' => __('about.about_deleted_successfully')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong')
            ], 500);
        }
    }

    public function changeStatus(About $about)
    {
        $this->aboutService->toggleAboutStatus($about);

        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated')
        ]);
    }

    public function changeOrder(Request $request, About $about)
    {
        $order = $request->order;
        $about->update(['order' => $order]);
        return response()->json([
            'success' => true,
            'message' => __('about.order_updated')
        ]);
       
    }
}
