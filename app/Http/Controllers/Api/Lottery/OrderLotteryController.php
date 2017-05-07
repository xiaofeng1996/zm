<?php

namespace App\Http\Controllers\Api\Lottery;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Lottery\OrderLotteryRepository as Lottery;

class OrderLotteryController extends Controller
{
    public function create(Request $request, Lottery $lottery)
    {
        $this->apiValidate($request, [
            'order_id' => 'required|integer',
            'selected_code' => 'nullable'
        ]);
        $lottery->create($request->userId, $request->input('order_id'), $request->input('selected_code'));
        return response()->api();
    }

    public function glance(Request $request, Lottery $lottery)
    {
        $lottery->glance($request->userId);
        return response()->api();
    }
}
