<?php

namespace App\Http\Controllers\Web\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\Goods;
use Repositories\CateRepository;
use Repositories\Web\Goods\GoodsAttrRepository as GoodsAttr;
use DB;
use Log;

class MemberGoodsController extends Controller
{
    public function index(Request $request, CateRepository $cate)
    {
        $keyword = $request->input('keyword');
        $cate_id = $request->input('cate_id');

        $user_id = $request->session()->get('user_id');

        $goods = Goods::where('is_lucky', 0)
                        ->withCount(['collects' => function ($query) use ($user_id) {
                            $query->where('user_id', $user_id);
                        }])
                        ->where(function ($query) use ($keyword, $cate_id, $cate) {
                            if ($keyword) {
                                $query->where('name', 'like', '%' . $keyword . '%');
                            }

                            if ($cate_id) {
                                $cate_ids = $cate->getChildrenIds($cate_id);
                                $query->whereIn('category_id', $cate_ids);
                            }
                        })
                        ->has('attrs')
                        ->reviewed()
                        ->orderBy('sort')
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);

        return view('web.goods.member')
                    ->with('goods', $goods)
                    ->with('keyword', $keyword);
    }

    public function detail($id, Request $request)
    {
        $user_id = $request->session()->get('user_id', 0);
        $goods = Goods::with(['images', 'merchant', 'richText', 'comments.user', 'comments.images'])
                        ->withCount(['collects' => function ($query) use ($user_id) {
                            $query->where('user_id', $user_id);
                        }])
                        ->withCount('comments')
                        ->withCount('goodComments')
                        ->reviewed()
                        ->find($id);
        if (!$goods) {
            abort(404);
        }
        return view('web.goods.detail')->with('goods', $goods);
    }

    public function getAttrs(Request $request, GoodsAttr $goods_attr)
    {
        $this->apiValidate($request, [
            'goods_id' => 'required|integer'
        ]);

        $attrs = $goods_attr->getAttrs($request->all());
        return response()->api($attrs);

    }

    public function getGoodRate(Request $request)
    {
        $this->apiValidate($request, [
            'goods_id' => 'required|integer'
        ]);
    }

}
