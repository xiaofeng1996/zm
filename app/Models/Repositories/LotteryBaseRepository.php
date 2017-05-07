<?php

namespace Repositories;

use Entities\Order;
use Entities\OrderGoods;
use Entities\Lottery;

class LotteryBaseRepository 
{
    public function getLotteryAllowInfo($order_id)
    {
        $data = [];

        // $order = Order::with('goods.goods_attr.goods')->find($order_id);
        // if (!$order->is_lucky) {
        //     return null;
        // }

        // $data['lucky_num'] = $order->goods[0]->goods_attr->goods->lucky_num;

        // // 拼接彩票开奖信息
        // $data['lottery_period'] = '2017021050';
        // $data['last_time'] = 60 * 5;

        $data['luck_num'] = 2;
        $data['options'] = [
            [
                'id' => 1,
                'num' => 5
            ],
            [
                'id' => 2,
                'num' => 5
            ]
        ];

        // 最新开奖信息
        $lottery = resolve('Lottery\LotteryService');
        $data['last'] = $lottery->lastLottery();

        return $data;

    }

    // 获取最近几期的开奖结果
    public function getLastsOpenCode()
    {
        $lottery = resolve('Lottery\LotteryService');

        $lotteries = $lottery->getLastsOpenCode();
        $next_lottery = $lottery->getNextExpect();

        $lotteries->prepend($next_lottery);

        return $lotteries;
    }

    public function getLast()
    {
        $lotterySrv = resolve('Lottery\LotteryService');
        $lottery = $lotterySrv->lastLottery();
        return $lottery;
    }

    // 根据开奖期数获取详情
    public function getLotteryByExpect($expect)
    {
        $lottery = Lottery::with('awards')->where('expect', $expect)->first();
        if (!$lottery) {
            $lotterySrv = resolve('Lottery\LotteryService');
            $lottery = $lotterySrv->getNextExpect();
            if ($lottery->expect == $expect) {
                $lottery->awards = [];
                return $lottery;
            } else {
                $std = new \stdClass();
                $std->id = 0;
                $std->expect = $expect;
                $std->opencode = null;
                $opentime = $lotterySrv->getOpenTimeByExpect($expect);
                $std->opentime = $opentime->format('Y-m-d H:i:s');
                $std->opentimestamp = $opentime->timestamp;
                $std->district = '新疆';
                $std->awards = [];
                return $std;
            }
        } else {
            return $lottery;
        }
    }
}