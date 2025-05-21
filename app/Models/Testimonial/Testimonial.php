<?php

namespace App\Models\Testimonial;

use App\Http\Filters\Filterable;
use App\Http\Filters\TestimonialFilter;
use App\Http\Resources\TestimonialResource;
use App\Models\BaseModel;
use App\Models\User;
use App\Traits\HasActivation;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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
