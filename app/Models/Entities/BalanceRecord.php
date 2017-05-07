<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BalanceRecord extends Model
{

    protected $hidden = ['updated_at'];

    protected $datas = ['created_at'];

    public function getCreatedAtAttribute($value)
    {
        $value = $value 
                 ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('Y.m.d H:i')
                 : Carbon::now()->format('Y.m.d H:i');
        return $value;
    }
}
