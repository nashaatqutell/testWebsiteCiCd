<?php

namespace App\Service;

use App\Http\Requests\Dashboard\Blogs\StoreBlogRequest;
use App\Http\Requests\Dashboard\Blogs\UpdateBlogRequest;
use App\Models\Blog\Blog;

class BlogService
{
    public function index($query)
    {
        $blogsQuery = Blog::query()->latest();
        return $query === 'paginate' ? $blogsQuery->paginate(10) : $blogsQuery->get();
    }

    public function list():\Illuminate\Database\Eloquent\Collection
    {
        return Blog::query()->latest()->get();
    }

    public function show(Blog $Blog) : Blog
    {
        return $Blog;
    }

    public function store(StoreBlogRequest $request) : Blog
    {
        $Blog = Blog::query()->create($request->validated());
        $Blog->storeImages(media: $request->image);
        return $Blog;
    }

    public function update(UpdateBlogRequest $request, Blog $Blog) : Blog
    {
        $Blog->update($request->validated());
        $Blog->storeImages(media: $request->image,update: true);
        return $Blog;
    }

    public function destroy(Blog $Blog) : void
    {
        $Blog->deleteMedia();
        $Blog->delete();
    }

    public function changeStatus(Blog $Blog) : Blog
    {
        $Blog->toggleActivation();
        return $Blog;
    }

}
