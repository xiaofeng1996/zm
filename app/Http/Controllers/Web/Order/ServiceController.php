<?php

namespace App\Http\Controllers\Web\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Web\Order\ServiceRepository as Service;
use Entities\Order;
use Entities\OrderGoods;
use Entities\OrderService;

class ServiceController extends Controller
{

    public function index(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $services = OrderService::with('goods')
                                ->where('user_id', $user_id)
                                ->orderBy('applied_service_at', 'desc')
                                ->get();
        return view('web.order.services')->with('services', $services);
    }

    public function show($id, Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $service = OrderService::with('goods', 'merchant', 'images')
                                ->where([
                                    ['user_id', $user_id],
                                    ['id', $id]
                                ])
                                ->first();
        return view('web.order.service_detail')->with('service', $service);
    }

    public function create($order_goods_id, Request $request, Service $service)
    {
        $user_id = $request->session()->get('user_id');
        $order_goods = OrderGoods::with('goods_attr', 'order')->find($order_goods_id);
        if ($order_goods) {
            $order = Order::find($order_goods->order_id);
            return view('web.order.service')->with('order_goods', $order_goods);
        } else {
            return redirect()->back();
        }
    }

    public function store(Request $request, Service $service)
    {
        $this->validate($request, [
            'order_goods_id'    => 'required|integer|min:1',
            'order_id'          => 'required|integer|min:1',
            'service_type'      => 'required|integer|min:1|max:2',
            'applied_reason'    => 'required',
        ]);
        $user_id = $request->session()->get('user_id');
        if ($service->isAllowApply($user_id, $request->order_goods_id)) {
            $service_id = $service->store($user_id, $request->all());
            if ($service_id) {
                $service->storeImg($service_id, $request);
            }
            return redirect('/order/' . $request->order_id);
        } else {
            return redirect()->back();
        }
    }
}