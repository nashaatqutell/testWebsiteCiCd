<?php

namespace App\Models\Slider;

use App\Http\Resources\SliderResource;
use App\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Slider extends BaseModel implements TranslatableContract
{
    use Translatable;

    protected $guarded = [];

    public $translatedAttributes = ['name', 'description'];

    public function getResource(): SliderResource
    {
        return new SliderResource($this->fresh());
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('slider_images')
            ->useDisk('public');
    }
}
