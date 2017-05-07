<?php

namespace App\Http\Controllers\Web\Lottery;

use App\Http\Controllers\Controller;
use Entities\OrderLottery;

class LotteryController extends Controller
{
    private $lotterySrv;
    public function __construct()
    {
        $this->lotterySrv = resolve('Lottery\LotteryService');
    }
    public function index ()
    {
        $lotteries = $this->lotterySrv->getLastsOpenCode(20);
        return view('web.lottery.index')->with('lotteries', $lotteries);
    }

    public function detail($expect)
    {
        $lottery = $this->lotterySrv->getLotteryByExpect($expect);
        if (!$lottery) {
            abort(404);
        } else {
            $win_records = OrderLottery::where([
                ['expect', $expect],
                ['status', 1]
            ])->orderBy('updated_at', 'desc')
            ->get();
            return view('web.lottery.detail')->with('lottery', $lottery)->with('win_records', $win_records);
        }
    }
}
