<?php

namespace App\Models\StaticPage;

use App\Http\Resources\StaticPageResource;
use App\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Str;

class StaticPage extends BaseModel implements TranslatableContract
{
    use Translatable;

    protected $guarded = [];

    public $translatedAttributes = ['name', 'description', 'meta_description'];

    protected static function booted()
    {
        static::creating(function (StaticPage $staticPage) {
            $staticPage->slug = Str::slug($staticPage->translate('en')->name);
        });
        static::saving(function (StaticPage $staticPage) {
            $newSlug = Str::slug($staticPage->translate('en')->name);
            if ($staticPage->slug !== $newSlug) {
                $staticPage->slug = $newSlug;
            }
        });
    }

    public function getResource(): StaticPageResource
    {
        return new StaticPageResource($this->fresh());
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('staticPage_images')
            ->useDisk('public');
    }
}
