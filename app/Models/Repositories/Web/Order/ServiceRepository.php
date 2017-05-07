<?php

namespace Repositories\Web\Order;

use Entities\Comment;
use Entities\OrderGoods;
use Entities\Order;
use Entities\Image;
use Entities\OrderService;
use DB;
use Carbon\Carbon;

class ServiceRepository 
{

    private $order = null;
    private $order_goods = null;

    public function isAllowApply($user_id, $order_goods_id)
    {
        $order_goods = $this->getOrderGoods($order_goods_id);
        return ($order_goods 
                && $order_goods->order 
                && $order_goods->order->user_id == $user_id 
                && $order_goods->service_status == 0)
                ? true
                : false;
    }

    public function store($user_id, $data)
    {
        $service_id = 0;
        DB::transaction (function () use ($user_id, $data, &$service_id) {
            $order_goods = $this->getOrderGoods($data['order_goods_id']);
            $service_id = OrderService::insertGetId([
                'user_id'               => $user_id,
                'order_goods_id'        => $data['order_goods_id'],
                'merchant_id'           => $order_goods->order->merchant_id,
                'service_status'        => '1',
                'service_type'          => $data['service_type'],
                'applied_service_at'    => Carbon::now(),
                'applied_fee'           => $order_goods->price * $order_goods->goods_num,
                'applied_goods_num'     => $order_goods->goods_num,
                'applied_reason'        => $data['applied_reason'],
                'is_lucky'              => $order_goods->goods_attr->goods->is_lucky
            ]);

            $order_goods->service_status = 1;
            $order_goods->save();
            $this->order_goods = $order_goods;
        });
        return $service_id;
    }

    public function storeImg($service_id, $request)
    {
        $data = [];
        for ($i = 0; $i < 4; $i++) {
            if ($request->hasFile('file' . $i)) {
                $path = '/storage/' . $request->{'file'.$i}->store('images', 'public');
                $data[] = [
                    'imageable_type'    => 'Entities\OrderService',
                    'imageable_id'      => $service_id,
                    'image'             => $path,
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now()
                ];

            }
        }
        Image::insert($data);
    }

    // private function getOrder($user_id, $order_id)
    // {
    //     if (!$this->order) {
    //         $order = Order::where([
    //             ['user_id', $user_id],
    //             ['id', $order_id]
    //         ])->first();
    //         $this->order = $order;
    //     } else {
    //         $order = $this->order;
    //     }
    //     return $order;
    // }

    private function getOrderGoods($order_goods_id)
    {
        if (!$this->order_goods) {
            $order_goods = OrderGoods::with('goods_attr.goods', 'order')->find($order_goods_id);
            $this->order_goods = $order_goods;
        } else {
            $order_goods = $this->order_goods;
        }
        return $order_goods;
    }
}