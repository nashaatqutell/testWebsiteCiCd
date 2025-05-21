<?php
namespace App\Observers;

use App\Models\Blog\Blog;
use Illuminate\Support\Str;

class BlogObserver
{
    public function creating(Blog $blog): void
    {
        $blog->slug = Str::slug($blog->translateOrNew(app()->getLocale())->name);
    }

    public function updating(Blog $blog): void
    {
        if ($blog->isDirty('name')) {
            $blog->slug = Str::slug($blog->translateOrNew(app()->getLocale())->name);
        }
    }

}
