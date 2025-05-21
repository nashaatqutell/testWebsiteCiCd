<?php
namespace App\Http\Controllers\Blade\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Categories\StoreCategoryRequest;
use App\Http\Requests\Dashboard\Categories\UpdateCategoryRequest;
use App\Models\Category\Category;
use App\Service\CategoryService;
use Exception;

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
        $categories = $this->categoryService->getAllCategories('get');
        return view('dashboard.category.index', get_defined_vars());
    }

    public function create()
    {
        return view('dashboard.category.single');
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->storeCategory($request->validated());
        return to_route('admin.categories.index')->with([
            'message'    => __("messages.success"),
            'alert-type' => 'success',
        ]);
    }

    public function edit(Category $category)
    {
        return view('dashboard.category.single', get_defined_vars());
    }

    // public function update(UpdateCategoryRequest $request, Category $category)
    // {
    //     $this->categoryService->updateCategory($category, $request->validated());
    //     return redirect()->route('admin.categories.index')->with(
    //         [
    //             "message"    => __("messages.update"),
    //             "alert-type" => "success",
    //         ]
    //     );

    // }

     public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->categoryService->updateCategory($request, $category);
        return redirect()->route('admin.categories.index', $category->id)->with(
            [
                "message" => __("messages.update"),
                "alert-type" => "success"
            ]
        );
    }

    public function destroy(Category $category)
    {
        try {
            $this->categoryService->deleteCategory($category);

            return response()->json([
                'success' => true,
                'message' => __('categories.category_deleted_successfully'),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('keys.something_wrong'),
            ], 500);
        }

    }

    public function changeStatus(Category $category)
    {
        $this->categoryService->toggleCategoryStatus($category);
        return response()->json([
            'success' => true,
            'message' => __('keys.status_updated'),
        ]);

    }
}
