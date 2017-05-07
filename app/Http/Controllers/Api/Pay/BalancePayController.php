<?php
/**
 * 余额支付
 */
namespace App\Http\Controllers\Api\Pay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Pay\BalancePayRepository as Pay;
use Repositories\User\BalanceRepository as Balance;

class BalancePayController extends Controller
{
    public function pay(Request $request, Pay $pay)
    {
        $this->apiValidate($request, [
            'order_id' => 'required|integer',
            'pay_password' => 'required'
        ]);
        $pay_result = $pay->pay($request->userId, $request->input('order_id'), $request->input('pay_password'));
        return response()->api();
    }

}
