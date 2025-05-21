<?php

namespace App\Models\Offer;

use Illuminate\Database\Eloquent\Model;

class OfferTranslation extends Model
{

    protected $fillable = [
        'name',
        'description',
    ];

    protected $table = 'offer_translations';
    public $timestamps = false;

}
