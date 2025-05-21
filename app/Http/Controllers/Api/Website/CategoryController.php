<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
     public function __invoke(Request $request)
    {
        $categories = Category::whereIsActive()->filter()->latest()->get();
        return $this->successResponse(CategoryResource::collection($categories));
    }
}
