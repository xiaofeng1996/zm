<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    use SoftDeletes;

    protected $dates = ['updated_at', 'deleted_at'];

    public $timestamps = false;

    protected $hidden = ['deleted_at'];

    public function goods()
    {
        return $this->hasMany('Entities\OrderGoods');
    }    

    public function merchant()
    {
        return $this->belongsTo('Entities\Merchant')
                    ->select('id', 'name', 'image', 'mobile', 'fare');
    }

    public function lotteries()
    {
        return $this->hasMany('Entities\OrderLottery');
    }

    public function scopeUser ($query, $user_id) 
    {
        $query->where('user_id', $user_id);
    }
}
