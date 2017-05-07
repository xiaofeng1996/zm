<?php

namespace Repositories;

use Carbon\Carbon;
use Entities\Order;
use Entities\Pay;
use DB;

class PayRepository 
{

    protected $pay_device = 0; // 1: 移动端, 2: pc 端

    // 获取订单信息
    public function getOrder($order_id)
    {
        $order = Order::find($order_id);
        return $order;
    }

    public function getOrderByUserIdAndOrderId($user_id, $order_id)
    {
        $order = Order::where([
            ['user_id', $user_id],
            ['id', $order_id]
        ])->first();
        if (!$order->id) {
            throw new \Exception('订单不存在');
        }
        if ($order->status > 1) {
            throw new \Exception('订单已支付');
        }
        return $order;
    }

    // 支付成功
    public function paySucc($out_trade_no, $total_money, $trade_no, $pay_type = 0, $fee_type = '')
    {
        $order = Order::where('out_trade_no', $out_trade_no)->first();
        if ($order->status === 1 && !$order->paid_at) {
            DB::transaction(function () use ($order, $total_money, $trade_no, $pay_type, $fee_type) {
                $this->chgOrderStatusAfterPaySucc($order);
                $this->chgPayStatusAfterPaySucc($order->user_id, $order->id, $total_money, $trade_no, $pay_type, $fee_type);
            });
        }
    }

    public function chgOrderStatusAfterPaySucc($order)
    {
        $order->status = 2;
        $order->paid_at = Carbon::now();
        $order->save();
    }

    public function chgPayStatusAfterPaySucc($user_id, $order_id, $money, $trade_no, $pay_type, $fee_type)
    {
        Pay::insert([
            'user_id' => $user_id,
            'keytype' => 1,
            'keyid' => $order_id,
            'money' => $money,
            'trade_no' => $trade_no,
            'pay_type' => $pay_type,
            'fee_type' => $fee_type,
            'pay_device' => $this->pay_device,
            'created_at' => Carbon::now()
        ]);
    }

}