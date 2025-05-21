<?php

namespace App\Models\Slider;

use App\Models\BaseModel;
use App\Models\User;
use App\Http\Resources\SliderResource;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

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
