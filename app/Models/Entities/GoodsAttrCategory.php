<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class GoodsAttrCategory extends Model
{

    public $timestamps = false;

    protected $table = 'goods_attr_category';

    public function values()
    {
        return $this->hasMany('Entities\GoodsAttr', 'goods_id', 'goods_id');
    }

    public function vals()
    {
        return $this->hasMany('Entities\GoodsAttrCategoryVal', 'goods_attr_category_id');
    }

}
