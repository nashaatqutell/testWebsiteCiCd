<?php

namespace App\Service;

use App\Models\Faq\Faq;

class FaqService
{
    public function getAllFaqs($query)
    {
        $faqsQuery = Faq::query()->latest();
        return $query === 'paginate' ? $faqsQuery->paginate(10) : $faqsQuery->get();
    }

    public function storeFaq($data)
    {
        return Faq::create($data + ['added_by_id' => auth()->user()->id]);
    }

    public function updateFaq(Faq $faq, $data)
    {
        $faq->update($data);
        return $faq;
    }

    public function deleteFaq(Faq $faq)
    {
        $faq->delete();
    }

    public function toggleFaqStatus(Faq $faq)
    {
        $faq->toggleActivation();
    }
}
