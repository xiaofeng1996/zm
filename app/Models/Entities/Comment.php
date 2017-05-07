<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $hidden = ['user_id', 'order_id', 'goods_id'];

    public function images()
    {
        return $this->morphMany('Entities\Image', 'imageable');
    }    

    public function user()
    {
        return $this->belongsTo('Entities\User')
                    ->select('id', 'name', 'avatar');
    }

}
