<?php

namespace App\Http\Controllers\Admin\Bussiness;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\OrderGoods;

class OrderGoodsController extends Controller
{
    public function index(Request $request)
    {
        $goods = OrderGoods::where('order_id', $request->order_id)->get();
        return response()->api($goods);
    }
}
