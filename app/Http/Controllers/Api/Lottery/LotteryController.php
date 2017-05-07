<?php

namespace App\Http\Controllers\Api\Lottery;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Lottery\LotteryRepository as Lottery;

class LotteryController extends Controller
{
    public function lasts(Lottery $lottery)
    {
        $lotteries = $lottery->getLastsOpenCode();
        return response()->api($lotteries);
    }

    public function last(Lottery $lottery)
    {
        $lottery = $lottery->getLast();
        return response()->api($lottery);
    }

    public function getLotteryByExpect(Request $request, Lottery $lottery)
    {
        $this->apiValidate($request, [
            'expect' => 'required'
        ]);
        $detail = $lottery->getLotteryByExpect($request->input('expect'));

        foreach ($detail->awards as $key => $v) {
            $detail->awards[$key]->mobile = substr($v->mobile, 0, 3) . '****' . substr($v->mobile, -4);
        }

        return response()->api($detail);
    }

}
