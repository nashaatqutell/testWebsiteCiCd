<?php

namespace App\Models\Work;

use App\Http\Filters\WorkFilter;
use App\Http\Resources\WorkResource;
use App\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

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
