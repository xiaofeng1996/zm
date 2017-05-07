<?php

namespace App\Http\Controllers\Admin\Bussiness;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Entities\GoodsAttrCategory as Cate;
use Entities\GoodsAttr;

class ProductAttrController extends Controller
{
    public function index($goods_id, Request $request)
    {
        $goods_attr_id = $request->goods_attr_id ? $request->goods_attr_id : 0;
        $cates = Cate::with('vals')->where('goods_id', $goods_id)->orderBy('attr_name')->get();
        $goods_attr = GoodsAttr::find($goods_attr_id);
        $datas = $this->composeData($cates, $goods_attr);
        return response()->api($datas);
    }

    private function composeData($cates, $goods_attr)
    {
        $datas = [];
        foreach ($cates as $cate) {
            $data['name'] = $cate->name;

            $field = $cate->attr_name;
            $data['field'] = $field;
            if ($goods_attr && $goods_attr->$field) {
                $data['value'] = $goods_attr->$field;
            } else {
                $data['value'] = $cate->name;
            }
            $data['vals'] = $cate->vals;
            $datas[] = $data;
        }
        return $datas;
    }

}
