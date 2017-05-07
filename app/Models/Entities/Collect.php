<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class Collect extends Model
{
    
    public function goods()
    {
        return $this->hasOne('Entities\Goods', 'id', 'goods_id');
    }
}
