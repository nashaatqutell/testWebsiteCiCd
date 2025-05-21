<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use App\Models\Faq\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{

    public function __invoke(Request $request)
    {
        $faqs = Faq::whereIsActive()->latest()->get();
        return $this->successResponse(FaqResource::collection($faqs));
    }
}
