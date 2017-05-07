<?php

namespace Repositories;

use DB;
use Entities\User;
use Entities\Order;
use Entities\Lottery;
use Entities\OrderLottery;
use Carbon\Carbon;
use App\Exceptions\ApiException;

class OrderLotteryBaseRepository 
{
    public function create($user_id, $order_id, $selected_code)
    {
        $code_array = $this->parseCodeToArray($selected_code);

        $this->check($user_id, $order_id);
        $now = Carbon::now();

        $lottery = resolve('Lottery\LotteryService');
        $expect = $lottery->getNextExpect();

        $user = User::find($user_id);

        $insert_data = [];
        foreach ($code_array as $key => $code) {
            $insert_data[$key]['user_id'] = $user_id;
            $insert_data[$key]['mobile'] = $user->mobile;
            $insert_data[$key]['order_id'] = $order_id;
            $insert_data[$key]['expect'] = $expect->expect;
            $insert_data[$key]['code'] = $code;
            $insert_data[$key]['opentime'] = $expect->opentime;
            $insert_data[$key]['opentimestamp'] = $expect->opentimestamp;
            $insert_data[$key]['status'] = 0;
            $insert_data[$key]['district'] = $expect->district;
            $insert_data[$key]['created_at'] = $now;
            $insert_data[$key]['updated_at'] = $now;
        }

        DB::transaction(function () use ($user_id, $order_id, $insert_data, $expect) {
            OrderLottery::insert($insert_data);

            Order::where([
                ['id', $order_id],
                ['user_id', $user_id]
            ])
            ->update([
                'is_bet' => 1,
                'lottery_expect' => $expect->expect
            ]);
        });

    }

    private function parseCodeToArray($selected_code)
    {
       if(!$selected_code) return;
       try {
           return explode('@', trim($selected_code));
       } catch (\Exception $e) {
           throw new \Exception('选号格式不正确');
       }
    }

    // 验证选号权限, 该订单允许的选号是否跟接受的参数相符
    private function check($user_id, $order_id)
    {
        $order = Order::where([
            ['user_id', $user_id],
            ['id', $order_id]
        ])->first();

        if (!$order) {
            throw new \Exception('订单不存在');
        }

        if ($order->status == 1) {
            throw new \Exception('订单未支付');
        }

        if (!$order->is_lucky) {
            throw new \Exception('该订单不是幸运区商品订单');
        }

        if ($order->is_bet) {
            throw new \Exception('该订单已选号');
        }
    }

    public function glance($user_id)
    {
        OrderLottery::where([
            ['user_id', $user_id],
            ['status', 1],
            ['is_glanced', 0]
        ])
        ->update(['is_glanced' => 1]);
    }

}