<?php

namespace App\Models\Seo;

use Illuminate\Database\Eloquent\Model;

class SeoTranslation extends Model
{

    protected $table = 'seo_translations';

    protected $fillable = [
        'meta_name',
        'meta_description',
        'meta_keywords',
    ];

    public $timestamps = false;


}
