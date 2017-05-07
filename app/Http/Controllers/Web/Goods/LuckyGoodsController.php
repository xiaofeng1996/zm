<?php

namespace App\Http\Controllers\Web\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\Goods;

class LuckyGoodsController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $user_id = $request->session()->get('user_id');
        $goods = Goods::where('is_lucky', 1)
                        ->withCount(['collects' => function ($query) use ($user_id) {
                            $query->where('user_id', $user_id);
                        }])
                        ->where(function ($query) use ($keyword) {
                            if ($keyword) {
                                $query->where('name', 'like', '%' . $keyword . '%');
                            }
                        })
                        ->has('attrs')
                        ->reviewed()
                        ->orderBy('sort')
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);
        return view('web.goods.lucky')->with('goods', $goods)
                                    ->with('keyword', $keyword);
    }
}
