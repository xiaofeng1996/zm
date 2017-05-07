<?php

namespace App\Http\Controllers\Api\Lottery;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Order\OrderRepository as Order;

class OrderController extends Controller
{
    public function index(Request $request, Order $order)
    {
        $this->apiValidate($request, [
            'page' => 'required|integer|min:1'
        ]);
        $orders = $order->getLuckyOrders($request->userId);
        return response()->api($orders);
    }
}
