<?php

namespace App\Models\Country;

use App\Http\Filters\CountryFilter;
use App\Http\Resources\CountryResource;
use App\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Country extends BaseModel implements TranslatableContract
{
    use Translatable;

    public function getResource(): CountryResource
    {
        return new CountryResource($this->fresh());
    }
    public $translatedAttributes = ['name'];

    protected $guarded = ['id'];

    protected $filter = CountryFilter::class;

}
