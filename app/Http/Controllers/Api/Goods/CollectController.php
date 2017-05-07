<?php

namespace App\Http\Controllers\Api\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Goods\CollectRepository as Collect;

class CollectController extends Controller
{
    public function index(Request $request, Collect $collect)
    {
        $this->apiValidate($request, [
            'goods_id' => 'required|integer'
        ]);
        $collect->collectSwitch($request->userId, $request->input('goods_id'));
        return response()->api();
    }
}
