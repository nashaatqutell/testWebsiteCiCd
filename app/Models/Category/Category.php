<?php
namespace App\Models\Category;

use App\Http\Filters\CategoryFilter;
use App\Http\Resources\CategoryResource;
use App\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends BaseModel implements TranslatableContract
{
    use Translatable;

    protected $table = 'categories';

    protected $fillable = ['is_active',"added_by_id"];

    public $translatedAttributes = ['name', 'description'];

    protected $filter = CategoryFilter::class;

    public function getResource(): CategoryResource
    {
        return new CategoryResource($this->fresh());
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('category_images')
            ->useDisk('public');
    }

}
