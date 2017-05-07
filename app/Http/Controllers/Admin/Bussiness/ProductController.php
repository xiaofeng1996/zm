<?php

namespace App\Http\Controllers\Admin\Bussiness;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\Goods;
use Carbon\Carbon;
use Entities\Admin;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $role_id = $request->session()->get('role_id');
        if ($role_id == 1) {
            $products = Goods::with('merchant', 'category')
                            ->withCount('attrs')
                            ->search($request->all())
                            ->orderBy('sort')
                            ->orderBy('created_at', 'desc')
                            ->paginate(20);
        } else {
            $admin_id = $request->session()->get('admin_id');
            $products = Goods::with('merchant', 'category')
                            ->with('attrs')
                            ->merchantGoods($admin_id)
                            ->search($request->all())
                            ->orderBy('sort')
                            ->orderBy('goods.created_at', 'desc')
                            ->select('goods.*')
                            ->paginate(20);
        }
        return response()->api($products);
    }

    public function store(Request $request)
    {
        $this->apiValidate($request, [
            'merchant_id'       => 'required|integer',
            'category_id'       => 'required|integer|min:1',
            'name'              => 'required',
            'image'             => 'required',
            'price'             => 'required|numeric',
            'old_price'         => 'required|numeric',
            'support_return'    => 'required|integer|min:0|max:1',
            'is_lucky'          => 'required|integer|min:0|max:1',
            'recommend'         => 'required|integer|min:0|max:1',
            'lucky_num'         => 'required|integer|min:0',
            'lucky_rate'        => 'required|numeric',
            'sort'              => 'required|integer'
        ]);

        $goods = $request->id
                ? Goods::find($request->id)
                : new Goods;

        if ($request->session()->get('role_id') == 1) {
            $goods->merchant_id = $request->merchant_id;
        } else {
            $admin = Admin::with('merchant')->find($request->session()->get('admin_id'));
            $goods->merchant_id = $admin->merchant->id;
        }

        $goods->category_id         = $request->category_id;
        $goods->name                = $request->name;
        $goods->image               = $request->image;
        $goods->price               = $request->price;
        $goods->old_price           = $request->old_price;
        $goods->support_return      = $request->support_return;
        $goods->is_lucky            = $request->is_lucky;
        $goods->recommend           = $request->recommend;
        $goods->lucky_num           = $request->lucky_num;
        $goods->lucky_rate          = $request->lucky_rate;
        $goods->sort                = $request->sort;
        $goods->review_status       = $request->review_status;
        $goods->created_at          = Carbon::now();
        $goods->updated_at          = Carbon::now();

        $goods->save();

        return response()->api();
    }

    public function destory($id)
    {
        Goods::where('id', $id)->delete();
        return response()->api();
    }
}
