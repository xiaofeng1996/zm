<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderLottery extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getMobileAttribute($value)
    {
        return substr($value, 0, 3) . '****' . substr($value, -4);
    }

    public function lottery()
    {
        return $this->belongsTo('Entities\Lottery', 'expect', 'expect');
    }

    public function order()
    {
        return $this->belongsTo('Entities\Order');
    }
}
