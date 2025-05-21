<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Testimonials\StoreTestimonialRequest;
use App\Http\Requests\Dashboard\Testimonials\UpdateTestimonialRequest;
use App\Models\Testimonial\Testimonial;
use App\Service\TestimonialService;
use Illuminate\Http\Request;
use Exception;


class TestimonialController extends Controller
{

    protected $testimonialService;

    public function __construct(TestimonialService $testimonialService)
    {
         $this->middleware('permission:show_testimonials')->only(['index', 'show']);
         $this->middleware('permission:create_testimonials')->only(['store']);
         $this->middleware('permission:update_testimonials')->only(['update']);
         $this->middleware('permission:delete_testimonials')->only(['destroy']);
         $this->middleware('permission:active_testimonials')->only(['changeStatus']);

        $this->testimonialService = $testimonialService;
    }
    public function index()
    {
        $testimonials = $this->testimonialService->getAllTestimonials('get');
        return view('dashboard.testimonial.index', get_defined_vars());
    }


    public function create()
    {
        return view('dashboard.testimonial.single');
    }


    public function store(StoreTestimonialRequest $request)
    {
        $this->testimonialService->storeTestimonial($request->validated());

        return to_route('admin.testimonials.index')->with(array(
            'message' => __("messages.success"),
            'alert-type' => 'success'
        ));
    }


    public function edit(Testimonial $testimonial)
    {
        return view('dashboard.testimonial.single', get_defined_vars());
    }


    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial)
    {
        $testimonial = $this->testimonialService->updateTestimonial($testimonial, $request->validated());

        return to_route('admin.testimonials.index')->with(
            array(
                "message" => __("messages.update"),
                "alert-type" => "success"
            )
        );
    }


    public function destroy(Testimonial $testimonial)
    {
        try {
            $this->testimonialService->deleteTestimonial($testimonial);
            return response()->json([
                'success' => true,
                'message' => __('keys.testimonial_deleted_successfully')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong')
            ], 500);
        }
    }


    public function changeStatus(Testimonial $testimonial)
    {
        $this->testimonialService->toggleTestimonialStatus($testimonial);

        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated')
        ]);
    }
}
