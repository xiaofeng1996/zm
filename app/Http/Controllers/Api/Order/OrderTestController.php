<?php

namespace App\Http\Controllers\Api\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\Order;
use Carbon\Carbon;

class OrderTestController extends Controller
{
    // 模拟发货
    public function deliverTest(Request $request)
    {
        if (env('APP_DEBUG')) {
            $this->apiValidate($request, [
                'order_id' => 'required|integer'   
            ]);
            $order = Order::find($request->input('order_id'));
            if ($order->status == 2) {
                $order->status = 3;
                $order->delivered_at = Carbon::now();
                $order->save();
            } else {
                throw new \Exception('请先支付');
            }
        }
        return response()->api();
    }
}
