<?php

namespace App\Services\Lottery;

use Entities\OrderLottery;
use Entities\Order;
use Carbon\Carbon;
use DB;

class WinningService
{
    public function checkWinning()
    {
        $orders = OrderLottery::with('lottery')->where('status', 0)->orderBy('expect', 'desc')->get();
        foreach ($orders as $order) {
            if ($order->lottery) {
                $is_win = $this->isWin($order->code, $order->lottery->opencode);
                // 更改订单状态
                $this->update($order, $is_win);
            }
        }
    }

    /**
     * @param $code 用户选号
     * @param $opencode 开奖号码
     */
    private function isWin($code, $opencode)
    {
        $codes = explode(',', $code);
        $codes_len = count($codes);
        $opencodes = explode(',', $opencode);
        $opencodes_last = array_slice($opencodes, -$codes_len);
        $diff = array_diff($codes, $opencodes_last);
        return count($diff) > 0 ? false : true;
    }

    /**
     * @param $order 彩票订单
     * @param $is_win 是否中奖
     */
    private function update($order, $is_win)
    {
        DB::transaction(function () use ($order, $is_win) {
            $this->updateOrderLottery($order, $is_win);
            $this->updateOrder($order, $is_win);
        });
    }

    private function updateOrderLottery($order, $is_win)
    {
        $order->opencode = $order->lottery->opencode;
        $order->status = $is_win ? 1 : 2;
        $order->award_desc = '奖品待定';
        $order->save();
    }

    private function updateOrder($order_lottery, $is_win)
    {
        $order = Order::find($order_lottery->order_id);
        if (!$order->award_status || ($order->award_status == 2 && $is_win)) {
            $order->award_status = $is_win ? 1 : 2;
            $order->opencode = $order->lottery->opencode;
            $order->save();
        }
    }
}
