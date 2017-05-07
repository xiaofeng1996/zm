<?php

namespace App\Http\Controllers\Web\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ApiException;
use Repositories\Web\Cart\CartRepository as Cart;
use Entities\User;
use Entities\Address;

class CartController extends Controller
{
    public function index(Request $request, Cart $cart)
    {
        $user_id = $request->session()->get('user_id');
        $carts = $cart->getList($user_id);
        $user = User::find($user_id);
        return view('web.user.cart.index')->with('carts', $carts)->with('user', $user);
    }

    public function add(Request $request, Cart $cart)
    {
        $this->apiValidate($request, [
            'attr_id' => 'required|integer|min:1',
            'goods_num' => 'required|integer|min:1'
        ]);
        $user_id = $request->session()->get('user_id');
        try {
            $cart->create($user_id, $request->all());
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
        return response()->api();

    }

    public function delete(Request $request, Cart $cart)
    {
        $this->apiValidate($request, [
            'cart_id' => 'required|integer'
        ]);
        $user_id = $request->session()->get('user_id');
        try {
            $cart->delete($user_id, $request->cart_id);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
        return response()->api();
    }

    public function update(Request $request, Cart $cart)
    {
        $this->apiValidate($request, [
            'cart_id' => 'required|integer|min:1',
            'goods_num' => 'required|integer|min:1'
        ]);
        $user_id = $request->session()->get('user_id');
        $cart->webUpdate($user_id, $request->cart_id, $request->goods_num);
        return response()->api();
    }

    /**
     * 购物车提交
     */
    public function createOrder(Request $request, Cart $cart)
    {
        $this->validate($request, [
            "data" => 'required|json'
        ]);
        $user_id = $request->session()->get('user_id');
        $prased_data = $cart->parseDataFromCartPost($user_id, $request->data);
        $addrs = Address::where('user_id', $user_id)
                        ->orderBy('is_default', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->get();
//        dd($show_datas[0]['attrs'][0]['attr']);
        return view('web.order.create_from_cart')->with('data', $request->data)
                        ->with('prased_data', $prased_data)
                        ->with('addrs', $addrs);
    }
}
