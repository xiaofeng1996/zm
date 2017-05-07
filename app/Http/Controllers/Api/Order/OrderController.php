<?php

namespace App\Http\Controllers\Api\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Order\OrderRepository as Order;
use Repositories\Api\Order\OrderCreateRepository as OrderCreate;
use Repositories\Api\Lottery\LotteryRepository as Lottery;

class OrderController extends Controller
{
    public function create(Request $request, OrderCreate $order, Lottery $lottery)
    {
        $this->apiValidate($request, [
            'name' => 'required|string',
            'mobile' => 'required',
            'address' => 'required|string',
            'goods' => 'required|json'
        ]);

        $data = $order->create($request->userId, $request->all());

        $data['lottery'] = $data['is_lucky'] 
                            ? $lottery->getLotteryAllowInfo($data['order_id'])
                            : null;

        return response()->api($data);
    }

    public function index(Request $request, Order $order)
    {
        $this->apiValidate($request, [
            'keytype' => 'required|integer'
        ]);        
        $list = $order->getList($request->userId, $request->input('keytype'));
        return response()->api($list);
    }

    public function one(Request $request, Order $order)
    {
        $this->apiValidate($request, [
            'order_id' => 'required|integer|min:1'
        ]);
        $data = $order->getOne($request->userId, $request->input('order_id'));
        return response()->api($data);
    }

    public function delete(Request $request, Order $order)
    {
        $this->apiValidate($request, [
            'order_id' => 'required|integer'
        ]);
        $order->delete($request->userId, $request->input('order_id'));
        return response()->api();
    }

    public function receipt(Request $request, Order $order)
    {
        $this->apiValidate($request, [
            'order_id' => 'required|integer'
        ]);
        $order->receipt($request->userId, $request->input('order_id'));
        return response()->api();
    }

}
