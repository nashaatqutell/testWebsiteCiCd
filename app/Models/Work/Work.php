<?php

namespace App\Models\Work;

use App\Models\BaseModel;
use App\Http\Filters\WorkFilter;
use App\Http\Resources\WorkResource;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Work extends BaseModel implements TranslatableContract
{
    use Translatable;
    protected $guarded = [];
    protected $translatedAttributes = ['name', 'description', 'meta_description', 'classification'];
    protected $filter = WorkFilter::class;

    public function getResource(): WorkResource
    {
        return new WorkResource($this->fresh());
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('work_images')
            ->useDisk('public');

        $this
            ->addMediaCollection('work_videos')
            ->useDisk('public');
    }
}
