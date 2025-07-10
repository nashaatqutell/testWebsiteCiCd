<?php

namespace App\Models\Faq;

use App\Http\Resources\FaqResource;
use App\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Faq extends BaseModel implements TranslatableContract
{
    use Translatable;

    public function getResource(): FaqResource
    {
        return new FaqResource($this->fresh());
    }

    public $translatedAttributes = ['question', 'answer'];

    protected $guarded = ['id'];

    //    protected $filter = FaqFilter::class;
}
