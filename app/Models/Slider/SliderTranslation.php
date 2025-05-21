<?php

namespace App\Models\Slider;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SliderTranslation extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $fillable = ['name', 'description'];
}
