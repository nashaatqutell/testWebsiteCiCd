<?php
namespace App\Models\JobHierarchy;

use Illuminate\Database\Eloquent\Model;

class JobHierarchyTranslation extends Model
{
    protected $table = 'job_hierarchy_translations';
    protected $guarded = ['id'];
    public $timestamps = false;
}
