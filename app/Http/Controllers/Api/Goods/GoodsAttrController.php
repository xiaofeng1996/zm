<?php

namespace App\Http\Controllers\Api\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Goods\GoodsAttrRepository as Attr;

class GoodsAttrController extends Controller
{
    public function getAttrs(Request $request, Attr $attr_rps)
    {
        $this->apiValidate($request, [
            'goods_id' => 'required|integer'
        ]);
        $categorys = $attr_rps->getAttrs($request->all());
        return response()->api($categorys);
    }
}
