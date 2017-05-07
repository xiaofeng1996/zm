<?php

namespace Repositories\Api\Order;

use Entities\Category;
use Entities\Order;
use Entities\OrderGoods;
use Entities\GoodsAttr as Attr;
use Entities\Goods;
use Entities\Merchant;
use Entities\Cart;
use DB;
use Carbon\Carbon;
use Repositories\Api\Order\OrderRepository;

class OrderCreateRepository extends OrderRepository
{
    public function create($user_id, $data)
    {

        $order_infos = $data['goods'];
        $order_infos = json_decode($order_infos);
        
        if (!count($order_infos)) {
            throw new \Exception('请正确提交订单数据');
        }

        $is_lucky_goods = $this->isLuckyGoods($order_infos); // 判断是不是从购物车中购买的商品

        $order_id = 0;
        DB::transaction(function () use ($user_id, $data, $order_infos, $is_lucky_goods, &$order_id) {

            $cart_ids = [];

            foreach ($order_infos as $order_info) {
                $handled_attr = $this->handleAttrs($order_info->attrs);
                $total_goods_num = $handled_attr['total_goods_num'];
                $attr_ids = $handled_attr['attr_ids'];
                $cart_ids = array_merge($cart_ids, $handled_attr['cart_ids']);
                $goods_num_arr = $handled_attr['goods_num_arr'];

                $attrs = $this->getAttrs($attr_ids);
                $total_money = $this->getTotalMoney($attrs, $goods_num_arr);

                $order_id = $this->createOrderGetId($user_id, $data, $order_info->merchant_id, $total_money, $total_goods_num, $is_lucky_goods);
                $this->addOutTradeNo($order_id);
                $this->createOrderGoods($order_id, $attrs, $goods_num_arr);
            }

            $this->removeCarts($cart_ids);
        });
        
        return ['order_id' => $order_id, 'is_lucky' => $is_lucky_goods];
    }

    private function createOrderGetId($user_id, $data, $merchant_id, $total_money, $total_goods_num, $is_lucky = 0)
    {
        $merchant = Merchant::find($merchant_id);
        if (!$merchant) {
            throw new \Exception('商家不存在');
        }

        $order_id = Order::insertGetId([
            'user_id' => $user_id,
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'address' => $data['address'],
            'merchant_id' => $merchant_id,
            'total_money' => $total_money + $merchant->fare,
            'fare' => $merchant->fare,
            'total_goods_num' => $total_goods_num,
            'status' => 1,
            'created_at' => Carbon::now(),
            'is_lucky' => $is_lucky
        ]);
        return $order_id;
    }

    private function addOutTradeNo($order_id)
    {
        $out_trade_no = 'DD' . time() . $order_id;
        Order::where('id', $order_id)->update(['out_trade_no' => $out_trade_no]);
    }

    private function handleAttrs($attrs)
    {
        $total_goods_num = 0;
        $attr_ids = [];
        $cart_ids = [];
        $goods_num_arr = [];
        if (count($attrs)) {
            foreach ($attrs as $attr) {
                $total_goods_num += intval($attr->goods_num);
                $attr_ids[] = $attr->attr_id;
                $cart_ids[] = $attr->cart_id ? $attr->cart_id : 0;
                $goods_num_arr[$attr->attr_id] = $attr->goods_num;
            }
            return [
                'total_goods_num' => $total_goods_num, 
                'attr_ids' => $attr_ids, 
                'cart_ids' => $cart_ids, 
                'goods_num_arr' => $goods_num_arr
            ];
        } else {
            throw new \Exception('请选择商品');
        }
    }

    // 根据 id 数组获取goods_attrs
    private function getAttrs($attr_ids)
    {
        $attrs = Attr::whereIn('id', $attr_ids)->get();
        return $attrs;
    }

    // 获取订单总价格
    private function getTotalMoney($attrs, $goods_num_arr)
    {
        $total_money = 0;
        foreach ($attrs as $attr) {
            $total_money += $attr->price * $goods_num_arr[$attr->id];
        }
        return $total_money;
    }

    // 创建order_goods
    private function createOrderGoods($order_id, $attrs, $goods_num_arr)
    {
        $data = [];
        foreach ($attrs as $attr) {
            $data[] = [
                'order_id' => $order_id,
                'attr_id' => $attr->id,
                'name' => $attr->title,
                'image' => $attr->image,
                'attr' => $this->formatAttrValue($attr),
                'price' => $attr->price,
                'goods_num' => $goods_num_arr[$attr->id],
                'service_status' => 0,
            ];
        }

        OrderGoods::insert($data);
        
    }

    // 格式化属性, 
    // @todo 这里跟模型耦合太多, 以后再优化
    private function formatAttrValue($attr)
    {
        $attr_keys = ['attr1', 'attr2', 'attr3', 'attr4', 'attr5', 'attr6', 'attr7'];
        $return_value = '';
        for ($i = 0; $i < 7; $i++) {
            $prop = $attr_keys[$i];
            if ($attr->$prop) {
                $return_value .= $attr->$prop . ' ';
            }
        }
        return trim($return_value);
    }

    private function removeCarts($cart_ids)
    {
        $cart_ids = array_unique($cart_ids);
        if ($cart_ids[0]) { // 购物车 id 不为0
            Cart::whereIn('id', $cart_ids)->delete();        
        }
    }

    // -------------------------------- 幸运区商品相关 -------------------------- start

    private function isLuckyGoods($order_infos)
    {
        if (count($order_infos) == 1) {
            $attrs = $order_infos[0]->attrs;
            if (count($attrs) == 1) {
                $attr_id = $attrs[0]->attr_id;
                $attr = Attr::find($attr_id);
                $goods_id = $attr ? $attr->goods_id : 0;
                $goods = Goods::find($goods_id);
                if ($goods && $goods->is_lucky) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    // -------------------------------- 幸运区商品相关 -------------------------- end
   
}