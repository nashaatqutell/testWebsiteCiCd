<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Blogs\StoreBlogRequest;
use App\Http\Requests\Dashboard\Blogs\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Http\Resources\SimpleDataResource;
use App\Models\Blog\Blog;
use App\Service\BlogService;
use Illuminate\Http\JsonResponse;

class BlogController extends Controller
{
    public function __construct(protected BlogService $blogService = new BlogService())
    {
        $this->middleware('permission:show_blogs')->only(['index', 'show']);
        $this->middleware('permission:create_blogs')->only(['store']);
        $this->middleware('permission:update_blogs')->only(['update']);
        $this->middleware('permission:delete_blogs')->only(['destroy']);
        $this->middleware('permission:active_blogs')->only(['changeStatus']);
    }

    public function index(): JsonResponse
    {
        $blogs = $this->blogService->index('paginate');
        return $this->paginateResponse(
            data: BlogResource::collection($blogs),
            collection: $blogs
        );
    }

    public function list()
    {
        $blogs = $this->blogService->list();
        return $this->successResponse(SimpleDataResource::collection($blogs));
    }

    public function show(Blog $blog): JsonResponse
    {
        return $this->successResponse(data: BlogResource::make($blog));
    }

    public function store(storeBlogRequest $request): JsonResponse
    {
        $blog = $this->blogService->store($request);
        return $this->successResponse(data: $blog->getResource(), message: __("messages.success"));
    }

    public function update(updateBlogRequest $request, Blog $blog): JsonResponse
    {
        $blog = $this->blogService->update($request, $blog);
        return $this->successResponse(data: $blog->getResource(), message: __("messages.update"));
    }

    public function destroy(Blog $blog): JsonResponse
    {
        $this->blogService->destroy($blog);
        return $this->successResponse(message: __("messages.delete"));
    }

    public function changeStatus(Blog $blog)
    {
        $blog = $this->blogService->changeStatus($blog);
        return $this->successResponse(message: __('messages.status_updated_successfully'));
    }
}
