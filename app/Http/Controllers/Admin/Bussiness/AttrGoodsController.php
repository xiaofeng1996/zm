<?php

namespace App\Http\Controllers\Admin\Bussiness;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\GoodsAttr;
use Entities\Goods;
use Carbon\Carbon;

class AttrGoodsController extends Controller
{
    public function index($goods_id)
    {
        $goods = GoodsAttr::where('goods_id', $goods_id)->orderBy('created_at', 'desc')->get();
        return response()->api($goods);
    }

    public function store(Request $request)
    {

        $goods = Goods::where('id', $request->goods_id)->first();

        $goods_attr = $request->id
            ? GoodsAttr::find($request->id)
            : new GoodsAttr;
        $goods_attr->goods_id   = $request->goods_id;
//        $goods_attr->title      = $request->title;
//        $goods_attr->price      = $request->price;
//        $goods_attr->image      = $request->image;
        $goods_attr->title      = $goods->name;
        $goods_attr->price      = $goods->price;
        $goods_attr->image      = $goods->image;
        $goods_attr->stock      = $request->stock;
        $goods_attr->created_at = Carbon::now();
        $goods_attr->updated_at = Carbon::now();

        // 暂时只支持两个属性的添加
        $goods_attr->attr1      = $request->attr1;
        $goods_attr->attr2      = $request->attr2;

        $goods_attr->save();
        return response()->api();
    }

    public function destory($id)
    {
        GoodsAttr::where('id', $id)->delete();
        return response()->api();
    }
}
