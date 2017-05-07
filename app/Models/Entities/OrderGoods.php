<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{
    protected $table = 'order_goods';
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo('Entities\Order');
    }

    public function goods_attr()
    {
        return $this->belongsTo('Entities\GoodsAttr', 'attr_id');
    }
}
