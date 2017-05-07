<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Cart extends Model
{
    use softDeletes;

    protected $dates = ['deleted_at'];

    protected $hidden = ['deleted_at'];

    public function merchant()
    {
        return $this->belongsTo('Entities\Merchant')
                    ->select('id', 'name', 'image', 'mobile', 'fare');
    }

    public function carts()
    {
        return $this->hasMany('Entities\Cart', 'merchant_id', 'merchant_id');
    }

    public function goods()
    {
        return $this->hasOne('Entities\GoodsAttr', 'id', 'attr_id')
                    ->select('id', 'title', 'image', 'price', 'stock')
                    ->addSelect(DB::raw('concat_ws(" ", attr1, attr2, attr3, attr4) as attr'));
    }

}
