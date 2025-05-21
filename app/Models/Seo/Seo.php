<?php

namespace App\Models\Seo;

use App\Http\Resources\SeoResource;
use App\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;


class Seo extends BaseModel implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ["meta_name","meta_description","meta_keywords"];
    protected $table = 'seos';
    protected $fillable = [
        "slug",
        "page_name",
        "is_active",
        "added_by_id"
    ];

    public function getResource(): SeoResource
    {
        return new SeoResource($this->fresh());
    }
}
