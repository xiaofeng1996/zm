<?php

namespace App\Http\Controllers\Admin\Lottery;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\OrderLottery;
use Carbon\Carbon;
use App\Exceptions\ApiException;

class WinController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $lotteries = OrderLottery::with('order')
                                ->whereHas('order', function ($query) use ($params) {
                                    $query->where('out_trade_no', 'like', '%' . $params['out_trade_no'] . '%');
                                })
                                ->where(function ($query) use ($params) {
                                    if ($params['expect']) {
                                        $query->where('expect', $params['expect']);
                                    }

                                    if ($params['status'] != -1) {
                                        $query->where('status', $params['status']);
                                    }

                                    if ($params['operate_status'] != -1) {
                                        $query->where('operate_status', $params['operate_status']);
                                    }
                                })
                                ->paginate();
        return response()->api($lotteries);
    }

    public function store(Request $request)
    {
        $order_lottery = OrderLottery::find($request->id);
        if (!$order_lottery) {
            throw new ApiException('订单不存在');
        }

        if ($order_lottery->status != 1 && $request->input('operate_status') > 0) {
            throw new ApiException('未中奖订单不能进行发货操作');
        }

        try {
            $order_lottery->operate_status  = $request->input('operate_status');
            $order_lottery->express_name    = $request->input('express_name');
            $order_lottery->express_nu      = $request->input('express_nu');
            $order_lottery->operated_at     = Carbon::now();

            $order_lottery->save();

            return response()->api();
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
    }

}
