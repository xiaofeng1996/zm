<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function products()
    {
        return $this->hasMany('Entities\Goods');
    }
}
