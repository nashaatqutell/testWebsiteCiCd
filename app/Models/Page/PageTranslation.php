<?php

namespace App\Models\Page;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageTranslation extends Model
{
    use SoftDeletes;
    protected $table = 'pages_translations';
    public $timestamps = false;
    protected $fillable = ['title', 'description', 'meta_description'];
}
