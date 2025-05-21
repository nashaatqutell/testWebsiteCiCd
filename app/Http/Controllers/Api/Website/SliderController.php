<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\SliderResource;
use App\Models\Slider\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $sliders = Slider::whereIsActive()->latest()->get();
        return $this->successResponse(SliderResource::collection($sliders));
    }
}
