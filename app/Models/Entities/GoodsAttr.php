<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class GoodsAttr extends Model
{
    protected $table = 'goods_attr';

    protected $hidden = ['attr3', 'attr4', 'attr5', 'attr6', 'attr7', 'created_at', 'updated_at'];    

    public function goods()
    {
        return $this->belongsTo('Entities\Goods');
    }

}
