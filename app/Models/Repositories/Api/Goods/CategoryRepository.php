<?php

namespace Repositories\Api\Goods;

use Entities\Category;

class CategoryRepository 
{
    // public function get
    public function getCascadeList()
    {
        $categorys = Category::where('parent_id', 0)->get();

        $result = [];
        foreach ($categorys as $key => $category) {
            $result[$key]['id'] = $category->id;
            $result[$key]['name'] = $category->name;
            $result[$key]['sort'] = $category->sort;
            $result[$key]['children'] = $category->children;
        } 
        return $result;
    }
}
