<?php

namespace Repositories;

use Entities\Cart;
use Entities\GoodsAttr;
use Entities\Goods;
use Carbon\Carbon;
use DB;

class CartBaseRepository
{
    // 加入购物车
    public function create($user_id, $data)
    {
        $cart = Cart::where([
            ['user_id', $user_id],
            ['attr_id', $data['attr_id']]
        ])->first();

        if ($cart) {
            $this->_update($cart, $data);
        } else {
            $this->_create($user_id, $data); 
        }
    }

    private function _update($cart, $data)
    {
        $cart->goods_num = $cart->goods_num + $data['goods_num'];
        $cart->updated_at = Carbon::now();
        $cart->save();
    }

    private function _create($user_id, $data) {
        $attr = GoodsAttr::find($data['attr_id']);
        if (!$attr) {
            throw new \Exception('商品不存在');
        }

        Cart::insert([
            'user_id' => $user_id,
            'merchant_id' => $attr->goods->merchant_id,
            'goods_id' => $attr->goods_id,
            'attr_id' => $data['attr_id'],
            'goods_num' => $data['goods_num'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    // 购物车列表
    public function getList($user_id)
    {
        // DB::enableQueryLog();
        $merchants = Cart::with(['merchant', 'carts.goods'])
                       ->where('user_id', $user_id)
                       ->groupBy('merchant_id')
                       ->groupBy('user_id')
                       ->orderBy('created_at', 'desc')
                       ->select('merchant_id')
                       ->get();
                    //    ->paginate(20);
        // dd(page_helper($merchants));
        // dd(DB::getQueryLog());
        // return page_helper($merchants);
        return $merchants;
    }

    // 更新购物车
    public function update($user_id, $data)
    {
        $cart = Cart::where([
                        ['user_id', $user_id],
                        ['id', $data['id']]
                    ])
                    ->first();
        if ($cart) {
            $cart->goods_num = $data['goods_num'];
            $cart->updated_at = Carbon::now();
            $cart->save();
        } else {
            throw new \Exception('购物车不存在');
        }
    }

    // 删除
    public function delete($user_id, $id)
    {
        $cart = Cart::where([
                        ['user_id', $user_id],
                        ['id', $id]
                    ])->first();

        if ($cart) {
            $cart->delete();
        } else {
            throw new \Exception('购物车不存在');
        }
    }

}
