<?php

namespace App\Models\Work;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkTranslation extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $fillable = ['name', 'description', 'meta_description','classification'];
}
