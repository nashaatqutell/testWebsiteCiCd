<?php

namespace App\Models\Partner;

use App\Http\Filters\PartnerFilter;
use App\Http\Resources\PartnerResource;
use App\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Partner extends BaseModel implements TranslatableContract
{
    use Translatable;

    protected $filter = PartnerFilter::class;

    protected $guarded = [];

    public $translatedAttributes = ['name'];

    public function getResource(): PartnerResource
    {
        return new PartnerResource($this->fresh());
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('partner_images')
            ->useDisk('public');
    }
}
