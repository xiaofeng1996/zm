<?php

namespace Repositories\Api\Order;

use Entities\Order;
use Entities\OrderService;
use Entities\OrderGoods;
use Carbon\Carbon;
use DB;

class OrderServiceRepository 
{
    public function apply($user_id, $data)
    {
        $order_goods = OrderGoods::with('order')->find($data['id']);
        if (!$order_goods) {
            throw new \Exception('订单商品不存在');
        }

        if (!in_array($order_goods->order->status, [3, 4, 5])) {
            throw new \Exception('该订单状态暂不提供售后服务');
        }

        if ($order_goods->service_status > 0) {
            throw new \Exception('售后已申请');
        }

        $service_id = 0;
        try {
            DB::transaction(function () use ($user_id, $data, $order_goods, &$service_id) {
                $service_id = OrderService::insertGetId([
                    'user_id' => $user_id, 
                    'merchant_id' => $order_goods->order->merchant_id,
                    'order_goods_id' => $data['id'],
                    'service_status' => 1,
                    'service_type' => $data['service_type'],
                    'applied_service_at' => Carbon::now(),
                    'applied_fee' => $order_goods->price * $order_goods->goods_num,
                    'applied_goods_num' => $order_goods->goods_num,
                    'applied_reason' => $data['applied_reason'],
                    'is_lucky' => $order_goods->order->is_lucky
                ]);

                $order_goods->service_status = 1;
                $order_goods->save();
                
            });
        } catch (\Exception $e) {
            throw new \Exception('申请错误, 稍后重试');
        }
        return $service_id;
    }

    public function getList($user_id, $service_status, $service_type)
    {
        $services = OrderService::with('merchant', 'goods', 'images')
                                ->where('user_id', $user_id)
                                ->where(function($query) use ($service_status, $service_type) {
                                    if ($service_status > 0) {
                                        $query->where('service_status', $service_status);
                                    }
                                    if ($service_type > 0) {
                                        $query->where('service_type', $service_type);
                                    }
                                })->paginate(20);
        return page_helper($services);
    }

    public function getOne($user_id, $service_id)
    {
        $service = OrderService::with('merchant', 'goods', 'images')
                                ->where([
                                    ['id', $service_id],
                                    ['user_id', $user_id]
                                ])
                                ->first();
        if (!$service) {
            throw new \Exception('售后申请不存在');
        }
        return $service;

    }

}