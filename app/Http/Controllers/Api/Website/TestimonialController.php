<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $testimonials = Testimonial::whereIsActive()->filter()->latest()->get();
        return $this->successResponse(TestimonialResource::collection($testimonials));
    }
}
