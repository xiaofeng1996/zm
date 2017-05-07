<?php

namespace Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends Model
{
    use SoftDeletes;
    protected $table = 'goods';

    protected $dates = ['deleted_at'];

    protected $hidden = ['updated_at', 'deleted_at'];

    public function getLuckyRateAttribute($value) {
        return $value . '%'; 
    }

    // 商品多图
    public function images()
    {
        return $this->morphMany('Entities\Image', 'imageable');
    }

    public function category()
    {
        return $this->hasOne('Entities\Category', 'id', 'category_id');
    }

    // 商品属性类别
    public function attrCategorys()
    {
        return $this->hasMany('Entities\GoodsAttrCategory');
    }

    // 商品属性
    public function attrs()
    {
        return $this->hasMany('Entities\GoodsAttr');
    }

    public function comments()
    {
        return $this->hasMany('Entities\Comment');
    }

    public function goodComments()
    {
        return $this->hasMany('Entities\Comment')->where('star', '>=', 4);
    }

    // 收藏 
    public function collects()
    {
        return $this->hasMany('Entities\Collect');
    }

    // merchant
    public function merchant()
    {
        return $this->belongsTo('Entities\Merchant');
    }

    public function richText()
    {
        return $this->hasOne('Entities\Html', 'htmlable_id', 'id')->where('htmlable_type', 'Entities\Goods');
//        return $this->morphMany('Entities\Html', 'htmlable');
    }

    // ------------------------ scope ------------------------------ start

    public function scopeMemberGoods($query)
    {
        return $query->where('is_lucky', 0);
    }

    public function scopeLuckyGoods($query)
    {
        return $query->where('is_lucky', 1);
    }

    public function scopeReviewed($query)
    {
        return $query->where('review_status', 1);
    }

    public function scopeRecommend($query)
    {
        return $query->where('recommend', 1);
    }

    /**
     * @param array searches
     *              name: 搜索商品名称
     *              is_lucky: -1: 获取全部商品， 0： 获取会员商品，1：获取幸运区商品
     */
    public function scopeSearch($query, $searches)
    {
        if (isset($searches['name'])) {
            $query = $query->where('goods.name', 'like', '%' . $searches['name'] . '%');
        }
        if (isset($searches['is_lucky'])) {
            $is_lucky = $searches['is_lucky'] ? $searches['is_lucky'] : 0;
            if ($is_lucky != -1) {
                $query = $query->where('is_lucky', $is_lucky); 
            }
        }
        return $query;
    }

    public function scopeMerchantGoods($query, $admin_id)
    {
        return $query->join('merchants', function ($join) use ($admin_id) {
            $join->on('goods.merchant_id', '=', 'merchants.id')
                ->where('merchants.admin_id', '=', $admin_id);
        });
    }

    // --------------------- 字段处理 ------------------------------ start

    public function getRichContentLinkAttribute($value)
    {
        return env('APP_URL') . $value;
    }

    // --------------------- 字段处理 ------------------------------ end

}
