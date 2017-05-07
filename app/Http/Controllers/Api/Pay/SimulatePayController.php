<?php

namespace App\Http\Controllers\Api\Pay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Pay\ApiPayRepository as Pay;
use Repositories\Api\Balance\BalanceRepository as Balance;

class SimulatePayController extends Controller
{
    public function pay(Request $request, Pay $pay, Balance $balance)
    {
        $this->apiValidate($request, [
            'keytype' => 'required|integer',
            'keyid' => 'required|integer',
        ]);
        $keytype = $request->keytype;
        $keyid = $request->keyid;
        $mobile = $request->mobile;

        switch ($keytype) {
            case 1:
                $order = $pay->getOrderByUserIdAndOrderId($request->userId, $request->input('keyid'));
                break;
            case 2:
                $order = $balance->createRecharge($request->userId, $request->input('mobile'));
                break;
            default:
                break;
        }

        $out_trade_no = $order->out_trade_no;

        $trade_no = 'test';
        $fee_type = 1;

        $order_type = substr($out_trade_no, 0, 2);
        switch ($order_type) {
            case 'DD':
                $pay->paySucc($out_trade_no, $order->total_money, $trade_no, 1, $fee_type);
                break;
            case 'CZ':
                $balance->rechargeSucc($out_trade_no, $order->total_money, $trade_no, 1, $fee_type);
                break;
            default:
                break;
        }
        
        return response()->api();
    }
}
