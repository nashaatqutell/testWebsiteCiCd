<?php

namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Blogs\StoreBlogRequest;
use App\Http\Requests\Dashboard\Blogs\UpdateBlogRequest;
use App\Models\Blog\Blog;
use App\Service\BlogService;
use Exception;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller
{
    private string $viewPath = 'dashboard.Blog.';
    private string $routePath = 'admin.blogs';

    public function __construct(protected BlogService $blogService = new BlogService())
    {
        $this->middleware('permission:show_blogs')->only(['index','show']);
        $this->middleware('permission:create_blogs')->only(['store']);
        $this->middleware('permission:update_blogs')->only(['update']);
        $this->middleware('permission:delete_blogs')->only(['destroy']);
        $this->middleware('permission:active_blogs')->only(['changeStatus']);
    }
    public function index()
    {
        $blogs = $this->blogService->index('get');
        return view($this->viewPath . 'index', get_defined_vars());
    }

    public function create()
    {
        return view($this->viewPath . 'single');
    }

    public function store(StoreBlogRequest $request)
    {

        $this->blogService->store($request);
        return $this->webSuccessResponse(route: $this->routePath . '.index', message: __("messages.success"));
    }

    public function edit(Blog $blog)
    {
        return view($this->viewPath . 'single', get_defined_vars());
    }

    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $this->blogService->update($request, $blog);
        return $this->webSuccessResponse(
            route: $this->routePath . '.index',
            message: __("messages.update")
        );
    }

    public function destroy(Blog $blog)
    {
        try {
            $this->blogService->destroy($blog);
            return response()->json([
                'success' => true,
                'message' => __('keys.deleted')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong')
            ], 500);
        }
    }

    public function changeStatus(Blog $blog)
    {
        $this->blogService->changeStatus($blog);

        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated'),
        ]);
    }

}
