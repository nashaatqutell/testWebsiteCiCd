<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog\Blog;

class BlogController extends Controller
{

    public function __invoke()
    {
        $blogs = Blog::query()->latest()->whereIsActive()->with("media")->get();
        return $this->successResponse(BlogResource::collection($blogs),message: __("messages.fetched_successfully"));
    }
}
