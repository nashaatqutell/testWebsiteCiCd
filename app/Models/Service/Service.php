<?php

namespace App\Models\Service;

use App\Models\BaseModel;
use App\Models\Page\Page;
use App\Http\Filters\ServiceFilter;
use App\Http\Resources\ServiceResource;
use App\Models\Scopes\OrderByOrderScope;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Contact\Contact;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Service extends BaseModel implements TranslatableContract
{
    use Translatable;

    protected $guarded = [];

    public $translatedAttributes = ['name', 'description'];

    protected $table = 'services';
    protected $filter = ServiceFilter::class;

    protected static function booted()
    {
        static::addGlobalScope(new OrderByOrderScope());
    }

    public function getResource(): ServiceResource
    {
        return new ServiceResource($this->fresh());
    }



    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('service_images')
            ->useDisk('public');

        $this
            ->addMediaCollection('service_videos')
            ->useDisk('public');
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function parent() : BelongsTo
    {
        return $this->belongsTo(Service::class, 'parent_id');
    }

    public function children() : HasMany
    {
        return $this->hasMany(Service::class, 'parent_id')
            ->whereIsActive()
            ->orderBy('order','asc');
    }

    public function getNextNode()
    {
        $nextNode = null;
        if ($this->children->count() > 0) {
            $nextNode = $this->children->first();
        }
        return $nextNode;
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }



}
