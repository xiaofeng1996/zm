<?php

namespace Repositories\Api\Order;

use Entities\Order;
use Carbon\Carbon;
use DB;

class OrderRepository 
{
    public function getList($user_id, $keytype = 0)
    {
        // DB::enableQueryLog();
        $list = Order::with('merchant', 'goods')
                    ->where(function ($query) use ($keytype) {
                        if ($keytype) {
                            $query->where('status', $keytype);
                        }
                    })
                    ->where('is_lucky', 0)
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);
        // dd(DB::getQueryLog());
        return page_helper($list);
    }

    public function getOne($user_id, $order_id)
    {
        $order = Order::with('merchant', 'goods', 'lotteries')
                        ->where([
                            ['id', $order_id],
                            ['user_id', $user_id]
                        ])
                        ->first();
        if (!$order) {
            throw new \Exception('订单不存在, 或已关闭');
        }
        return $order;
    }

    public function delete($user_id, $order_id)
    {
        $order = Order::where([
            ['user_id', $user_id],
            ['id', $order_id]
        ])->first();

        if (!$order) {
            throw new \Exception('订单不存在');
        }

        if (!in_array($order->status, [1, 4, 5, 6])) {
            throw new \Exception('订单不能删除');
        }

        $order->delete();
    }

    public function receipt($user_id, $order_id)
    {
        $order = Order::where([
            ['user_id', $user_id],
            ['id', $order_id]
        ])->first();

        if (!$order) {
            throw new \Exception('订单不存在');
        }

        if ($order->status != 3) {
            throw new \Exception('确认收货失败');
        }

        $order->status = 4;
        $order->receipted_at = Carbon::now();

        $order->save();
    }

    public function getLuckyOrders($user_id)
    {
        $list = Order::with('merchant', 'goods', 'lotteries')
                    ->where([
                        ['user_id', $user_id],
                        ['is_lucky', 1]
                    ])
                    ->paginate(20);
        return page_helper($list);
    }

}