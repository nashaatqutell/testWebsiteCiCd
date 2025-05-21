<?php
namespace App\Models\JobHierarchy;

use App\Http\Filters\JobHierarchyFilter;
use App\Http\Resources\JobResource;
use App\Models\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobHierarchy extends BaseModel implements TranslatableContract
{
    use Translatable;

    protected $table = 'job_hierarchies';

    protected $filter = JobHierarchyFilter::class;

    protected $fillable = ['is_active', "added_by_id", "parent_id"];

    public $translatedAttributes = ['name', 'position', 'description'];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('job_images')
            ->useDisk('public');
    }


    public function getResource(): JobResource
    {
        return new JobResource($this->fresh());
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(JobHierarchy::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(JobHierarchy::class, 'parent_id');
    }
}
