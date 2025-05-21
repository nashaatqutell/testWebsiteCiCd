<?php
namespace App\Models\Category;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{

    protected $table = 'categories_translations';
    protected $guarded = ['id'];
    public $timestamps = false;
}
