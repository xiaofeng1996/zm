<?php

namespace App\Http\Controllers\Api\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Cart\CartRepository as Cart;

class CartController extends Controller
{
    public function create(Request $request, Cart $cart)
    {
        $this->apiValidate($request, [
            'attr_id' => 'required|integer',
            'goods_num' => 'required|integer|min:1'
        ]);
        $cart->create($request->userId, $request->all());
        return response()->api();
    }

    // 列表
    public function index(Request $request, Cart $cart)
    {
        $this->apiValidate($request, [
            // 'page' => 'required|integer|min:1'
        ]);
        $list = $cart->getList($request->userId);
        return response()->api($list);
    }

    // 更改购物车
    public function update(Request $request, Cart $cart)
    {
        $this->apiValidate($request, [
            'id' => 'required|integer|min:1',
            'goods_num' => 'required|integer|min:1'
        ]);
        $cart->update($request->userId, $request->all());
        return response()->api();
    }

    // 删除购物车
    public function delete(Request $request, Cart $cart)
    {
        $this->apiValidate($request, [
            'id' => 'required|integer|min:1'
        ]);
        $cart->delete($request->userId, $request->input('id'));
        return response()->api();
    }

}
