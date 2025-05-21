<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Work\StoreWorkRequest;
use App\Http\Requests\Dashboard\Work\UpdateWorkRequest;
use App\Models\Work\Work;
use App\Service\WorkService;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    protected $workService;

    public function  __construct(WorkService $workService)
    {
        $this->workService = $workService;
        $this->middleware('permission:show_works')->only(['index','show']);
        $this->middleware('permission:create_works')->only(['store']);
        $this->middleware('permission:update_works')->only(['update']);
        $this->middleware('permission:delete_works')->only(['destroy']);
        $this->middleware('permission:active_works')->only(['changeStatus']);
    }

    public function index()
    {
        $works = $this->workService->index('get');
        return view('dashboard.works.index',get_defined_vars());
    }


    public function create()
    {
        $work = new Work();
        return view('dashboard.works.single',get_defined_vars());
    }

    public function store(StoreWorkRequest $request)
    {

        $this->workService->store($request);
        return redirect()->route('admin.works.index')->with(array(
            'message' => __("messages.success"),
            'alert-type' => 'success'
        ));
    }

    public function edit(Work $work)
    {
        return view('dashboard.works.single',get_defined_vars());
    }


    public function update(UpdateWorkRequest $request, Work  $work)
    {
        $this->workService->update($request, $work);
        return redirect()->route('admin.works.index')->with(
            array(
                "message" => __("messages.update"),
                "alert-type" => "success"
            )
        );
    }
    public function destroy(Work $work)
    {
        try {
            $this->workService->destroy($work);
            return response()->json([
                'success' => true,
                'message' => __('work.works_deleted_successfully')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong')
            ], 500);
        }

    }
    public function changeStatus(Work $work)
    {
        $this->workService->changeStatus($work);
        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated')
        ]);
    }
}
