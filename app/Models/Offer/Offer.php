<?php

namespace App\Models\Offer;

use App\Http\Filters\Filterable;
use App\Http\Resources\OfferResource;
use App\Models\BaseModel;
use App\Models\User;
use App\Traits\HasActivation;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends BaseModel implements TranslatableContract
{

    use Translatable;


    public array $translatedAttributes = ['name', 'description'];

    protected $fillable = [
        'name',
        'description',
        "is_active",
        "added_by_id",
        "price",
        "discount_percent"
    ];
    public function getResource(): OfferResource
    {
        return new OfferResource($this->fresh());
    }
}
