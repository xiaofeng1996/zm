<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class OrderService extends Model
{
    public $timestamps = false;


    public function images()
    {
        return $this->morphMany('Entities\Image', 'imageable');
    }

    public function goods()
    {
        return $this->belongsTo('Entities\OrderGoods', 'order_goods_id');
    }

    public function merchant()
    {
        return $this->belongsTo('Entities\Merchant')
                    ->select('id','name', 'image', 'mobile');
    }
}
