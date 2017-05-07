<?php

namespace App\Http\Controllers\Web\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\Merchant;
use Entities\Goods;

class MerchantController extends Controller
{
    public function getDetail($id, Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $merchant = Merchant::find($id);
        if (!$merchant) abort(404);

        $goods = Goods::where([
                    ['merchant_id', $merchant->id],
                    ['is_lucky', 0]
                ])
                ->withCount(['collects' => function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                }])
                ->orderBy('sort')
                ->orderBy('created_at', 'desc')
                ->paginate(20);

        return view('web.goods.merchant')->with('merchant', $merchant)
                                        ->with('goods', $goods);
    }
}
