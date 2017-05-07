<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    public $timestamps = false;

    public function awards()
    {
        return $this->hasMany('Entities\OrderLottery', 'expect', 'expect')
                    ->where('status', 1)
                    ->orderBy('created_at', 'desc')
                    ->limit(100);
    }

}
