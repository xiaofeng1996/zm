<?php

namespace App\Http\Controllers\Web\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\Collect;
use Carbon\Carbon;

class CollectController extends Controller
{
    /**
     * 收藏/取消收藏
     */
    public function update(Request $request)
    {
        $this->apiValidate($request, [
            'id' => 'required|integer'
        ]);
        $user_id = $request->session()->get('user_id');
        $collect = Collect::where([
            ['user_id', $user_id],
            ['goods_id', $request->id]
        ])->first();
        if ($collect) {
            $collect->delete();
        } else {
            Collect::insert([
                'user_id' => $user_id,
                'goods_id' => $request->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        $is_collect = $collect ? 0 : 1;
        return response()->api(['is_collect' => $is_collect]);
    }

    /**
     * 会员区商品收藏列表
     */
    public function member(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $collects = Collect::where([
                        ['user_id', $user_id],
                    ])
                    ->join('goods', function ($join) {
                        $join->on('collects.goods_id', '=', 'goods.id')
                            ->where('goods.is_lucky', 0);
                    })
                    ->with('goods')
                    ->paginate(20);
        return view('web.user.collect.member')->with('collects', $collects);
    }

    /**
     * 幸运区收藏列表
     */
    public function lucky(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $collects = Collect::where([
                    ['user_id', $user_id],
                ])
                ->join('goods', function ($join) {
                    $join->on('collects.goods_id', '=', 'goods.id')
                        ->where('goods.is_lucky', 1);
                })
                ->with('goods')
                ->paginate(20);
        return view('web.user.collect.lucky')->with('collects', $collects);
    }


}
