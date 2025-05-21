<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Testimonials\StoreTestimonialRequest;
use App\Http\Requests\Dashboard\Testimonials\UpdateTestimonialRequest;
use App\Http\Resources\SimpleDataResource;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial\Testimonial;
use App\Service\TestimonialService;

class TestimonialController extends Controller
{
    protected $testimonialService;

    public function __construct(TestimonialService $testimonialService)
    {
        $this->middleware('permission:show_testimonials')->only(['index','show']);
        $this->middleware('permission:create_testimonials')->only(['store']);
        $this->middleware('permission:update_testimonials')->only(['update']);
        $this->middleware('permission:delete_testimonials')->only(['destroy']);
        $this->middleware('permission:active_testimonials')->only(['changeStatus']);

        $this->testimonialService = $testimonialService;
    }

    public function index()
    {
        $testimonials = $this->testimonialService->getAllTestimonials('paginate');
        return $this->paginateResponse(TestimonialResource::collection($testimonials), $testimonials);
    }

    public function list()
    {
        $testimonials = $this->testimonialService->listTestimonials();
        return $this->successResponse(SimpleDataResource::collection($testimonials));
    }

    public function store(StoreTestimonialRequest $request)
    {
        $testimonial = $this->testimonialService->storeTestimonial($request->validated());
        return $this->successResponse(data: $testimonial->getResource(), message: __('messages.success'));
    }

    public function show(Testimonial $testimonial)
    {
        return $this->successResponse(data: TestimonialResource::make($testimonial));
    }

    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial)
    {
        $testimonial = $this->testimonialService->updateTestimonial($testimonial, $request->validated());
        return $this->successResponse(data: $testimonial->getResource(), message: __('messages.update'));
    }

    public function destroy(Testimonial $testimonial)
    {
        $this->testimonialService->deleteTestimonial($testimonial);
        return $this->successResponse(message: __('messages.delete'));
    }

    public function changeStatus(Testimonial $testimonial)
    {
        $this->testimonialService->toggleTestimonialStatus($testimonial);
        return $this->successResponse(message: __('messages.update'));
    }
}
