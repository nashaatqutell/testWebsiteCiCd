<?php

namespace App\Models\HeroSection;

use App\Http\Resources\HeroSectionResource;
use App\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class HeroSection extends BaseModel implements TranslatableContract
{
    use Translatable;

    protected $guarded = [];

    public $translatedAttributes = ['name', 'sub_description', 'description'];

    public function getResource(): HeroSectionResource
    {
        return new HeroSectionResource($this->fresh());
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('heroSection_images')
            ->useDisk('public');

        $this
            ->addMediaCollection('heroSection_videos')
            ->useDisk('public');
    }

    //    public function setImages($image)
    //    {
    //        $this->addMedia($image)->toMediaCollection('heroSection_images');
    //    }
    //
    //    public function getImages()
    //    {
    //        return $this->getMedia('heroSection_images');
    //    }
    //    public function setVideo($video)
    //    {
    //        $this->addMedia($video)->toMediaCollection('heroSection_videos');
    //    }
    //    public function getVideo()
    //    {
    //        return $this->getMedia('heroSection_videos')->first();
    //    }

}
