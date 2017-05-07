<?php

namespace App\Http\Controllers\Api\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Goods\GoodsRepository as Goods;

class GoodsController extends Controller
{
    /**
     * 商品列表
     * @param string token 登录 token
     * @param int keytype 获取类型
     * @param int category 商品分类
     * @param string keyword 搜索关键字 
     * @param int page 页码  
     * @param int keyid
     */
    public function index(Request $request, Goods $goods)
    {
        $this->apiValidate($request, [
            'token' => 'string|nullable',
            'keytype' => 'required|integer',
            'category' => 'requiredIf:keytype,4|integer',
            'keyword' => 'requiredIf:keytype,5|string',
            'page' => 'required|integer',
            'keyid' => 'required_if:keytype,9'
        ]);

        $list = $goods->getList($request->all());
        return response()->api($list);

    }

    public function getOne(Request $request, Goods $goods)
    {
        $this->apiValidate($request, [
            'token' => 'string|nullable',
            'goods_id' => 'required|integer'
        ]);
        $one = $goods->getOne($request->all());
        return response()->api($one);
    }

}
