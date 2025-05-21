<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Faqs\StoreFaqRequest;
use App\Http\Requests\Dashboard\Faqs\UpdateFaqRequest;
use App\Models\Faq\Faq;
use App\Service\FaqService;
use Illuminate\Http\Request;
use Exception;

class FaqController extends Controller
{
    protected $faqService;

    public function __construct(FaqService $faqService)
    {
        $this->middleware('permission:show_fags')->only(['index', 'show']);
        $this->middleware('permission:create_fags')->only(['store']);
        $this->middleware('permission:update_fags')->only(['update']);
        $this->middleware('permission:delete_fags')->only(['destroy']);
        $this->middleware('permission:active_fags')->only(['changeStatus']);

        $this->faqService = $faqService;
    }
    public function index()
    {
        $faqs = $this->faqService->getAllFaqs('get');
        return view('dashboard.faq.index', get_defined_vars());
    }


    public function create()
    {
        return view('dashboard.faq.single');
    }


    public function store(StoreFaqRequest $request)
    {
        $this->faqService->storeFaq($request->validated());

        return to_route('admin.faqs.index')->with(array(
            'message' => __("messages.success"),
            'alert-type' => 'success'
        ));
    }


    public function edit(Faq $faq)
    {
        return view('dashboard.faq.single', get_defined_vars());
    }


    public function update(UpdateFaqRequest $request, Faq $faq)
    {
        $faq = $this->faqService->updateFaq($faq, $request->validated());

        return to_route('admin.faqs.index')->with(
            array(
                "message" => __("messages.update"),
                "alert-type" => "success"
            )
        );
    }


    public function destroy(Faq $faq)
    {
        try {
            $this->faqService->deleteFaq($faq);
            return response()->json([
                'success' => true,
                'message' => __('keys.faq_deleted_successfully')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong')
            ], 500);
        }
    }

    public function changeStatus(Faq $faq)
    {
        $this->faqService->toggleFaqStatus($faq);

        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated')
        ]);
    }
}
