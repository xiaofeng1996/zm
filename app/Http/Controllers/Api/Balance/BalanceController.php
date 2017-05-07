<?php

namespace App\Http\Controllers\Api\Balance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Balance\BalanceRepository as Balance;

class BalanceController extends Controller
{
    // 获取账户信息
    public function index(Request $request, Balance $balance)
    {
        $this->apiValidate($request, [
            'type' => 'required|integer',
            'page' => 'required|integer'
        ]);
        $list = $balance->getList($request->userId, $request->input('type'));
        return response()->api($list);
    }
}
