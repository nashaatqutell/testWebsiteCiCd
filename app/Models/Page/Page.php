<?php

namespace App\Models\Page;

use App\Http\Resources\PageResource;
use App\Models\BaseModel;
use App\Models\Service\Service;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Page extends BaseModel implements TranslatableContract
{
    use Translatable;
    protected $guarded = [];

    public $translatedAttributes = ['title', 'description','meta_description'];


    public function getResource(): PageResource
    {
        return new PageResource($this->fresh());
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('Page_images')
            ->useDisk('public');
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

}
