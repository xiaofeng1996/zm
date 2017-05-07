<?php

namespace App\Http\Controllers\Web\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\Order;
use Repositories\Web\Lottery\LotteryRepository as Lottery;

class PaySuccController extends Controller
{
    public function show(Request $request, Lottery $lottery)
    {
        $out_trade_no = $request->out_trade_no;
        $user_id = $request->session()->get('user_id');
        $order = Order::with('merchant', 'goods')->user($user_id)->where('out_trade_no', $out_trade_no)->first();
        $lottery = $order->is_lucky 
                    ? $lottery->getLotteryAllowInfo($order->id)
                    : null;
        return view('web.order.pay_succ')->with('order', $order)
                                         ->with('lottery', $lottery);
    }
}
