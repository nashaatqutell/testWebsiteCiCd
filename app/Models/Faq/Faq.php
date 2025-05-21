<?php

namespace App\Models\Faq;

use App\Http\Filters\Filterable;
use App\Http\Resources\CountryResource;
use App\Http\Resources\FaqResource;
use App\Models\BaseModel;
use App\Models\User;
use App\Traits\HasActivation;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends BaseModel implements TranslatableContract
{
    use Translatable;

    public function getResource(): FaqResource
    {
        return new FaqResource($this->fresh());
    }
    public $translatedAttributes = ['question','answer'];

    protected $guarded = ['id'];

//    protected $filter = FaqFilter::class;
}
