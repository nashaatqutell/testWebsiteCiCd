<?php
namespace App\Service;

use App\Http\Requests\Dashboard\Categories\UpdateCategoryRequest;
use App\Models\Category\Category;

class CategoryService
{
    public function getAllCategories($query)
    {
        $categoriesQuery = Category::filter()->latest();
        return $query === 'paginate' ? $categoriesQuery->paginate(10) : $categoriesQuery->get();
    }

    public function listCategories()
    {
        return Category::latest()->get();
    }

    public function storeCategory($data)
    {
        $category = Category::create($data + ['added_by_id' => auth()->user()->id]);
        $category->storeImages(media: $data['image'], collection: 'category_images');
        return $category;

    }

    public function updateCategory(UpdateCategoryRequest $request, Category $category)
    {
        // $category->update($data);

        // if (isset($data['image'])) {
        //     $category->storeImages(media: $data['image'], update: true, collection: 'category_images');
        // }

        // return $category;

        $validatedDate = collect($request->validated())->except(['image'])->toArray();
        $category->update($validatedDate);

        $category->storeImages(media: $request->file('image'), update: true, collection: 'category_images');

        return $category;
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        $category->clearMediaCollection('category_images');
    }

    public function toggleCategoryStatus(Category $category)
    {
        $category->toggleActivation();
        return $category;
    }
}
