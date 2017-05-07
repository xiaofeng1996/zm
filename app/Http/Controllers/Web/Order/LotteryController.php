<?php

namespace App\Http\Controllers\Web\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Web\Order\LotteryRepository as Lottery;
use App\Exceptions\ApiException;

class LotteryController extends Controller
{
    public function store(Request $request, Lottery $lottery) {
        $this->apiValidate($request, [
            'order_id' => 'required|integer',
            'selected_code' => 'nullable'
        ]);
        $user_id = $request->session()->get('user_id');
        try {
            $lottery->create($user_id, $request->input('order_id'), $request->input('selected_code'));
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
        return response()->api();
    }
}
