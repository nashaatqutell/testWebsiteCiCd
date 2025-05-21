<?php

namespace App\Service;

use App\Models\Testimonial\Testimonial;

class TestimonialService
{
    public function getAllTestimonials($query)
    {
        $testimonialQuery = Testimonial::filter()->latest();
        return $query === 'paginate' ? $testimonialQuery->paginate(10) : $testimonialQuery->get();
    }

    public function listTestimonials()
    {
        return Testimonial::latest()->get();
    }

    public function storeTestimonial($data)
    {
        $testimonial = Testimonial::create($data + ['added_by_id' => auth()->user()->id]);

        if (isset($data['image'])) {
            $testimonial->addMedia($data['image'])->toMediaCollection('testimonial_images');
        }

        return $testimonial;
    }

    public function updateTestimonial(Testimonial $testimonial, $data)
    {
        $testimonial->update($data);

        if (isset($data['image'])) {
            $testimonial->clearMediaCollection('testimonial_images');
            $testimonial->addMedia($data['image'])->toMediaCollection('testimonial_images');
        }

        return $testimonial;
    }

    public function deleteTestimonial(Testimonial $testimonial)
    {
        $testimonial->delete();
        $testimonial->clearMediaCollection('testimonial_images');
    }

    public function toggleTestimonialStatus(Testimonial $testimonial)
    {
        $testimonial->toggleActivation();
    }
}
