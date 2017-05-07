<?php

namespace App\Services\Lottery;

use Entities\Lottery;
use Carbon\Carbon;

class LotteryService
{

    // 新疆时时彩
    private $district = '新疆';
    private $url = 'http://f.apiplus.cn/xjssc.json';
    private $expect_counts = 96;

    public function __construct()
    {
    }

    // 把开奖结果存到本地数据库
    public function saveLotteries()
    {
        $data_json = json_decode(file_get_contents($this->url));
        $data = $data_json->data;
        // $local_last_lottery = Lottery::orderBy('opentimestamp', 'desc')->first();
        $local_last_lottery = $this->lastLottery();

        $insert_data = [];
        for ($i = count($data) - 1; $i >= 0; $i--) {
            if (!$local_last_lottery || ($data[$i]->opentimestamp > $local_last_lottery->opentimestamp)) {
                $insert_data[$i]['expect'] = $data[$i]->expect;
                $insert_data[$i]['opencode'] = $data[$i]->opencode;
                $insert_data[$i]['opentime'] = $data[$i]->opentime;
                $insert_data[$i]['opentimestamp'] = $data[$i]->opentimestamp;
                $insert_data[$i]['district'] = $this->district;
                $insert_data[$i]['created_at'] = Carbon::now();
            }
        }

        Lottery::insert($insert_data);

    }

    // 获取最新开奖结果
    public function lastLottery()
    {
        $lottery = Lottery::orderBy('opentimestamp', 'desc')->first();
        return $lottery;
    }

    // 根据给出的期数获取下一期期数, 只是用于新疆时时彩
    public function getNextExpect()
    {
        $last_end_dt = Carbon::createFromTime(2, 0, 0);
        $start_dt = Carbon::createFromTime(10, 0, 0);
        $now = Carbon::now();

        if ($now < $last_end_dt->subMinutes(2)) {
            $seconds_diff = $now->timestamp - $start_dt->subDay()->timestamp;
            $expect_nu = floor($seconds_diff / (60 * 10)) + 1;
            $expect = $expect_nu < 10 ? $now->subDay()->format('Ymd') . '00' . $expect_nu : $now->subDay()->format('Ymd') . '0' . $expect_nu;
            $opentime = $start_dt->subDay()->addMinutes(($expect_nu - 1) * 10);
        } else if ($now < $start_dt->subMinutes(2)) {
            $expect_nu = 1;
            $expect = $expect_nu < 10 ? $now->format('Ymd') . '00' . $expect_nu : $now->format('Ymd') . '0' . $expect_nu;
            $opentime = $start_dt;
        } else {
            $seconds_diff = $now->timestamp - $start_dt->timestamp;
            $expect_nu = floor($seconds_diff / (60 * 10)) + 1;
            $expect = $expect_nu < 10 ? $now->format('Ymd') . '00' . $expect_nu : $now->format('Ymd') . '0' . $expect_nu;
            $opentime = $start_dt->addMinutes(($expect_nu - 1) * 10);
        }

        $std = new \stdClass();

        $std->id = 0;
        
        $std->expect = $expect;

        $std->opencode = null;
        $std->opentime = $opentime->toDateTimeString();
        $std->opentimestamp = $opentime->timestamp;
        $std->district = $this->district;
        
        return $std;

    }

    // 获取最近几期开奖结果
    public function getLastsOpenCode($limits = 3)
    {
        $lotteries = Lottery::orderBy('opentimestamp', 'desc')->limit($limits)->get();
        return $lotteries ? $lotteries : [];
    }

    public function getOpenTimeByExpect($expect)
    {
        $start_dt = Carbon::createFromTime(10, 0, 0);

        $expect_nu = intval(substr($expect, -2));
        if ($expect_nu < 84) {
            $opentime = $start_dt->addMinutes(($expect_nu - 1) * 10);
        } else {
            $opentime = $start_dt->subDay()->addMinutes(($expect_nu - 1) * 10);
        }
        return $opentime;
    }

    public function getLotteryByExpect($expect)
    {
        $lottery = Lottery::where('expect', $expect)->first();
        return $lottery;
    }
}
