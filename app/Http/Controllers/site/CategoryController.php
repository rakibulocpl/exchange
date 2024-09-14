<?php

namespace App\Http\Controllers\site;

use App\Models\Categories;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //
    public function getSubCategory($parentId){
        $categories = ProductCategory::where('parent_id',$parentId)->get();
        return response()->json($categories);
    }

    public function getCategoryById($categoryId){
        $category = ProductCategory::where('id',$categoryId)->first();
        return response()->json($category);
    }
}
