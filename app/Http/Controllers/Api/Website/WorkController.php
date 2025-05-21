<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\WorkResource;
use App\Models\Work\Work;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $works = Work::whereIsActive()->latest()->get();
        return $this->successResponse(WorkResource::collection($works));
    }
}
