<?php

namespace App\Http\Controllers\Web\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\GoodsAttr;
use Entities\GoodsAttrCategory as Category;
use Entities\Address;
use Repositories\Web\Order\OrderCreateRepository as OrderCreate;
use Repositories\Web\Lottery\LotteryRepository as Lottery;
use Repositories\Web\Order\OrderRepository as Order;

class OrderController extends Controller
{
    public function index(Request $request, Order $order)
    {
        $is_lucky = $request->is_lucky ? 1 : 0;
        $user_id = $request->session()->get('user_id');
        $orders = $order->getList($user_id, $request->keytype, $is_lucky);

        return view('web.order.index')->with('orders', $orders)
                                      ->with('is_lucky', $is_lucky);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'attr_id' => 'required|integer|min:1',
            'goods_num' => 'required|integer|min:1'
        ]);
        $attr = $this->getAttr(($request));
        $attr_cates = $this->getAttrCates($attr);
        $addrs = $this->getAddrs($request);
        return view('web.order.create')
                    ->with('addrs', $addrs)
                    ->with('attr_cates', $attr_cates)
                    ->with('attr', $attr)
                    ->with('goods_num', $request->goods_num);
    }

    public function store(Request $request, OrderCreate $order_create, Lottery $lottery)
    {
        $this->apiValidate($request, [
            'name' => 'required|string',
            'mobile' => 'required',
            'address' => 'required|string',
            'goods' => 'required|json'
        ]);
        $data = $order_create->create($request->session()->get('user_id'), $request->all());

        $data['lottery'] = $data['is_lucky']
            ? $lottery->getLotteryAllowInfo($data['order_id'])
            : null;
 
        return response()->api($data);

        // $order = $order_create->getOrderById($data['order_id']);
        // $lottery = $data['is_lucky']
        //     ? $lottery->getLotteryAllowInfo($data['order_id'])
        //     : null;

        // return view('web.order.pay_succ')->with('order', $order)
        //                                  ->with('lottery', $lottery);

    }

    public function show($id, Request $request, Order $order_repo)
    {
        $user_id = $request->session()->get('user_id');
        $order = $order_repo->getOne($user_id, $id);
        return view('web.order.detail')->with('order', $order);
    }

    private function getAttr($request)
    {
        $attr = GoodsAttr::with('goods.merchant')->find($request->attr_id);
        if (!$attr) {
            abort(404);
        }
        return $attr;
    }

    private function getAttrCates($attr)
    {
        $attr_cates = Category::where('goods_id', $attr->goods_id)->get();
        return $attr_cates;
    }

    private function getAddrs($request)
    {
        $user_id = $request->session()->get('user_id');
        $addrs = Address::where('user_id', $user_id)
                        ->orderBy('is_default', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->limit(3)
                        ->get();
        return $addrs;
    }
}
