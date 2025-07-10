<?php

namespace App\Models\Testimonial;

use App\Http\Filters\TestimonialFilter;
use App\Http\Resources\TestimonialResource;
use App\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Testimonial extends BaseModel implements TranslatableContract
{
    use Translatable;

    public function getResource(): TestimonialResource
    {
        return new TestimonialResource($this->fresh());
    }

    public $translatedAttributes = ['description'];

    protected $guarded = ['id'];

    protected $filter = TestimonialFilter::class;
}
