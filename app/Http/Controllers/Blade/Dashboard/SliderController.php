<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Slider\StoreSliderRequest;
use App\Http\Requests\Dashboard\Slider\UpdateSliderRequest;
use App\Models\Slider\Slider;
use App\Service\SliderService;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    protected $sliderService;

    public function  __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
        $this->middleware('permission:show_sliders')->only(['index','show']);
        $this->middleware('permission:create_sliders')->only(['store']);
        $this->middleware('permission:update_sliders')->only(['update']);
        $this->middleware('permission:delete_sliders')->only(['destroy']);
        $this->middleware('permission:active_sliders')->only(['changeStatus']);
    }

    public function index()
    {
        $sliders = $this->sliderService->index('get');
        return view('dashboard.sliders.index',get_defined_vars());
    }


    public function create()
    {
        $slider = new Slider();
        return view('dashboard.sliders.single',get_defined_vars());
    }

    public function store(StoreSliderRequest $request)
    {

        $this->sliderService->store($request);
        return redirect()->route('admin.sliders.index')->with(array(
            'message' => __("messages.success"),
            'alert-type' => 'success'
        ));
    }

    public function edit(Slider $slider)
    {
        return view('dashboard.sliders.single',get_defined_vars());
    }


    public function update(UpdateSliderRequest $request, Slider  $slider)
    {
        $this->sliderService->update($request, $slider);
        return redirect()->route('admin.sliders.index')->with(
            array(
                "message" => __("messages.update"),
                "alert-type" => "success"
            )
        );
    }
    public function destroy(Slider $slider)
    {
        try {
            $this->sliderService->destroy($slider);
            return response()->json([
                'success' => true,
                'message' => __('slider.sliders_deleted_successfully')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong')
            ], 500);
        }

    }
    public function changeStatus(Slider $slider)
    {
        $this->sliderService->changeStatus($slider);
        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated')
        ]);
    }
}
