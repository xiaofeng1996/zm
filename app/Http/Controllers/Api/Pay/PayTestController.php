<?php

namespace App\Http\Controllers\Api\Pay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Pay\ApiPayRepository as Pay;

class PayTestController extends Controller
{
    public function index(Request $request, Pay $pay)
    {
        $this->apiValidate($request, [
            'order_id' => 'required|integer'
        ]);
        $order = $pay->getOrder($request->input('order_id'));

        $fee_type = 'CNY';
        $total_money = '100';
        $trade_no = time();
        $pay->paySucc($order->out_trade_no, $total_money, $trade_no, 1, $fee_type);
        
        return response()->api();

    }
}
