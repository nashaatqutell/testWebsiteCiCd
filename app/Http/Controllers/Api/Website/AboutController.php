<?php

namespace App\Http\Controllers\Api\Website;

use App\Enums\About\TypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Website\About\AboutRequest;
use App\Http\Resources\AboutResource;
use App\Models\About\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function __invoke(Request $request)
    {
        $abouts = About::whereIsActive()->filter()->orderBy('order','asc')->get();
        if ($request->type == TypeEnum::About->value) {
            $about = About::whereIsActive()->filter()->first();
            return $this->successResponse(AboutResource::make($about));
        }
        return $this->successResponse(AboutResource::collection($abouts));
    }

    public function fetchVision(Request $request)
    {
        $abouts = About::whereType(TypeEnum::Vision->value)->first();
        if (!$abouts) {
            return $this->errorResponse(message: __("keys.no_found_records"));
        }
        return $this->successResponse(AboutResource::make($abouts));
    }
}
