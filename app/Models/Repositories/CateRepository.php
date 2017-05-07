<?php

namespace Repositories;

use Entities\Category;

class CateRepository
{
    public function getChildrenIds($cate_id, $ids = [])
    {
        $ids[] = $cate_id;
        $cates = Category::with('children')->find($cate_id);
        if (count($cates->children)) {
            foreach ($cates->children as $child) {
                $ids = $this->getChildrenIds($child->id, $ids);
            }
            return $ids;
        } else {
            return $ids;
        }
    }
}