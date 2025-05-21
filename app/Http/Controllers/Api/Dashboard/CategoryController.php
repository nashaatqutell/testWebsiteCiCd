<?php
namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Categories\StoreCategoryRequest;
use App\Http\Requests\Dashboard\Categories\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SimpleDataResource;
use App\Models\Category\Category;
use App\Service\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->middleware('permission:show_categories')->only(['index', 'show']);
        $this->middleware('permission:create_categories')->only(['store']);
        $this->middleware('permission:update_categories')->only(['update']);
        $this->middleware('permission:delete_categories')->only(['destroy']);
        $this->middleware('permission:active_categories')->only(['changeStatus']);

        $this->categoryService = $categoryService;
    }
    public function index()
    {
        $categories = $this->categoryService->getAllCategories('paginate');
        return $this->paginateResponse(CategoryResource::collection($categories), $categories);
    }

    public function list()
    {
        $categories = $this->categoryService->listCategories();
        return $this->successResponse(SimpleDataResource::collection($categories));
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->storeCategory($request->validated());
        return $this->successResponse(data: $category->getResource(), message: __('messages.success'));
    }

    public function show(Category $category)
    {
        return $this->successResponse(data: CategoryResource::make($category));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category =  $this->categoryService->updateCategory($request, $category);
        return $this->successResponse(data: $category->getResource(), message: __('messages.update'));
    }

    public function destroy(Category $category)
    {
        $this->categoryService->deleteCategory($category);
        return $this->successResponse(message: __('messages.delete'));
    }

    public function changeStatus(Category $category)
    {
        $this->categoryService->toggleCategoryStatus($category);
        return $this->successResponse(message: __('messages.update'));
    }

}
