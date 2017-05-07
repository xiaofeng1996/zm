<?php

namespace App\Http\Controllers\Admin\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        $categories = formatDataToCascade($categories);
        return response()->api($categories);
    }

    public function store(Request $request)
    {
        $this->apiValidate($request, [
            'id'            => 'required|integer|min:0',
            'parent_id'     => 'required|integer|min:0',
            'name'          => 'required',
            'image'         => 'required',
            'sort'          => 'required|integer'
        ]);

        $category = $this->getCategory($request->id);

        if ($category) {

            $category->parent_id    = $request->parent_id;
            $category->name         = $request->name;
            $category->image        = $request->image;
            $category->sort         = $request->sort;
            $category->lv           = $this->getLv($request->parent_id);

            $category->save();
            return response()->api();
        } else {
            return response()->api('类别不存在', 0);
        }

    }

    private function getCategory($id)
    {
        if ($id > 0) {
            $category = Category::find(intval($id));
        } else {
            $category = new Category;
        }
        return $category;
    }

    private function getLv($parent_id)
    {
        if ($parent_id) {
            $parent_category = Category::find(intval($parent_id));
            if ($parent_category) {
                return ($parent_category->lv + 1);
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function destory(Request $request)
    {
        Category::where('id', $request->id)->delete();
        return response()->api();
    }

    public function getCatesByParentId($parent_id)
    {
        $cates = Category::where('parent_id', $parent_id)->get();
        return response()->api($cates);
    }

}
