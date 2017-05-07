<?php

namespace App\Http\Controllers\Api\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Goods\CategoryRepository as Category;

class CategoryController extends Controller
{
    public function index(Category $category)
    {
        $categorys = $category->getCascadeList();
        return response()->api($categorys);
    }
}
