<?php

namespace App\Models\About;

use App\Http\Filters\AboutFilter;

use App\Http\Resources\AboutResource;
use App\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class About extends BaseModel implements TranslatableContract
{
    use Translatable;

    public function getResource(): AboutResource
    {
        return new AboutResource($this->fresh());
    }
    public $translatedAttributes = ['name','description','meta_title','meta_description'];

    protected $guarded = ['id'];

    protected $filter = AboutFilter::class;

}
