<?php

namespace Repositories\Web\Cart;

use App\Exceptions\ApiException;
use Repositories\CartBaseRepository;
use Entities\Cart;
use Carbon\Carbon;
use Entities\Merchant;
use Entities\GoodsAttr;

class CartRepository extends CartBaseRepository
{
    public function webUpdate($user_id, $cart_id, $goods_num)
    {
        $cart = Cart::where([
            ['user_id', $user_id],
            ['id', $cart_id]
        ])->first();
        if (!$cart) {
            throw new ApiException('购物车信息不存在');
        }
        $cart->goods_num = $goods_num;
        $cart->updated_at = Carbon::now();
        $cart->save();
    }

    /**
     * 处理购物车提交的数据
     * @param $user_id
     * @param $datas
     */
    public function parseDataFromCartPost($user_id, $datas)
    {
        $show_datas = [];
        $total_price = 0;

        $datas = json_decode($datas);
        foreach ($datas as $data_key => $data) {
            $attr_datas = [];
            $merchant_total_price = 0;

            $attrs = $data->attrs;
            foreach ($attrs as $attr_key => $attr) {
                $cart_id = $attr->cart_id;
                $this->isCartIdValid($user_id, $cart_id);

                $attr_id = $attr->attr_id;
                $goods_attr = GoodsAttr::with('goods.merchant')->find($attr_id);
                $attr_datas[$attr_key]['attr'] = $goods_attr;

                $goods_num = $attr->goods_num;
                $attr_datas[$attr_key]['goods_num'] = $goods_num;

                $price = $attr->price;
                $merchant_total_price += $price * $goods_num;
            }
            $show_datas[$data_key]['attrs'] = $attr_datas;
            $show_datas[$data_key]['total_price'] = $merchant_total_price;

            $total_price += $merchant_total_price;
        }
        return ['total_price' => $total_price, 'show_datas' => $show_datas];
    }

    /**
     * 检查购物车是否合法
     */
    private function isCartIdValid($user_id, $cart_id)
    {
        $cart = Cart::where([
            ['user_id', $user_id],
            ['id', $cart_id]
        ])->first();
        if (!$cart) {
            throw new ApiException('商品未加入购物车');
        }
    }

}
