<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Faqs\StoreFaqRequest;
use App\Http\Requests\Dashboard\Faqs\UpdateFaqRequest;
use App\Http\Resources\FaqResource;
use App\Models\Faq\Faq;
use App\Service\FaqService;

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
        $faqs = $this->faqService->getAllFaqs('paginate');
        return $this->paginateResponse(FaqResource::collection($faqs), $faqs);
    }

    public function store(StoreFaqRequest $request)
    {
        $faq = $this->faqService->storeFaq($request->validated());
        return $this->successResponse(data: $faq->getResource(), message: __('messages.success'));
    }

    public function show(Faq $faq)
    {
        return $this->successResponse(data: FaqResource::make($faq));
    }

    public function update(UpdateFaqRequest $request, Faq $faq)
    {
        $faq = $this->faqService->updateFaq($faq, $request->validated());
        return $this->successResponse(data: $faq->getResource(), message: __('messages.update'));
    }

    public function destroy(Faq $faq)
    {
        $this->faqService->deleteFaq($faq);
        return $this->successResponse(message: __('messages.delete'));
    }

    public function changeStatus(Faq $faq)
    {
        $this->faqService->toggleFaqStatus($faq);
        return $this->successResponse(message: __('messages.update'));
    }
}
