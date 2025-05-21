<?php

namespace App\Models\Partner;

use App\Models\BaseModel;
use App\Models\User;
use App\Traits\HasActivation;
use App\Http\Filters\Filterable;
use App\Http\Filters\PartnerFilter;
use App\Http\Resources\PartnerResource;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;


class Partner extends BaseModel  implements TranslatableContract
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
