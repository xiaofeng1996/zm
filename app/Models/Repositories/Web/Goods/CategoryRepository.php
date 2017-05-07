<?php

namespace Repositories\Web\Goods;

use Entities\Category;

class CategoryRepository 
{
    public function getCascadeList()
    {
        $categorys = Category::where('parent_id', 0)->get();
        return $categorys;
    }
}
