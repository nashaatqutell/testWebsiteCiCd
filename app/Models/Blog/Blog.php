<?php

namespace App\Models\Blog;

use App\Http\Filters\BlogFilter;
use App\Http\Resources\BlogResource;
use App\Models\BaseModel;
use App\Observers\BlogObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

#[ObservedBy([BlogObserver::class])]
class Blog extends BaseModel implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['name', 'description'];

    protected string $filter = BlogFilter::class;

    protected $fillable = [
        'name',
        'description',
        "slug",
        "is_active",
        "added_by_id",
    ];

    public function getResource(): BlogResource
    {
        return new BlogResource($this->fresh());
    }
}
