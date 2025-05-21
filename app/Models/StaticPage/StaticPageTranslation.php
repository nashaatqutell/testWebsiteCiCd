<?php

namespace App\Models\StaticPage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaticPageTranslation extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $fillable = ['name', 'description', 'meta_description'];
}
