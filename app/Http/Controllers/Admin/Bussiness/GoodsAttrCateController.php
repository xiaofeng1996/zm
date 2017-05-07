<?php

namespace App\Http\Controllers\Admin\Bussiness;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\GoodsAttrCategory as Cate;
use Entities\GoodsAttrCategoryVal as CateVal;
use Entities\Goods;
use Entities\Admin;
use DB;
use App\Exceptions\ApiException;

class GoodsAttrCateController extends Controller
{
    public function index($goods_id)
    {
        $cates = Cate::with('vals')->where('goods_id', $goods_id)->orderBy('attr_name')->get();
        return response()->api($cates);
    }

    public function store(Request $request)
    {
        $this->apiValidate($request, [
            'goods_id' => 'required|integer|min:1',
            'name' => 'required',
            'vals' => 'required|array'
        ]);

        try {
            if ($request->id) {
                $cate_id = $this->_store($request);
            } else {
                $cate_id = $this->_create($request);
            }

            $this->_saveCateVals($cate_id, $request);

        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }

        return response()->api();
    }


    private function _store($request)
    {
        $cate = Cate::find($request->id);
        $cate->name = $request->name;
        $cate->save();
        return $cate->id;
    }

    private function _create($request)
    {
        $cate = new Cate;

        $cates_count = Cate::where('goods_id', $request->goods_id)->count();
        $goods = Goods::find($request->goods_id);

        $cate->name         = $request->name;
        $cate->merchant_id  = $goods->merchant_id;
        $cate->goods_id     = $request->goods_id;
        $cate->attr_name    = 'attr' . ($cates_count + 1);

        $cate->save();

        return $cate->id;

    }

    private function _saveCateVals($cate_id, $request)
    {
        $vals = $request->vals;
        $this->destoryUnnecessaryVal($cate_id, $vals);
        foreach ($vals as $val) {
            if ($val['id']) {
                CateVal::where('id', $val['id'])->update(['val' => $val['val']]);
            } else {
                CateVal::insert([
                    'goods_attr_category_id' => $cate_id,
                    'val'   => $val['val']
                ]);
            }
        }
    }

    private function destoryUnnecessaryVal($cate_id, $vals)
    {
        $ids = [];
        foreach ($vals as $key => $val) {
            if ($val['id'] > 0) {
                $ids[] = $val['id'];
            }
        }
        CateVal::whereNotIn('id', $ids)->where('goods_attr_category_id', $cate_id)->delete();
    }

    public function destory(Request $request)
    {
        $this->apiValidate($request, [
            'id'        => 'required|integer|min:1',
            'goods_id'  => 'required|integer|min:1'
        ]);

        $this->_isAllowDestory($request);

        // $cates = Cate::where('goods_id', $request->goods_id)->get();
        DB::transaction(function () use ($request) {
            // $this->_destoryAllCates($request->goods_id);
            Cate::where('id', $request->id)->delete();
            $this->_resetCates($request->goods_id);
            // $new_cates = $this->_filterCates($cates, $request->id);
            // $new_cates = $this->_resetCates($new_cates);
            // $this->_insertNewCates($new_cates);
        });
        return response()->api();
    }

    private function _isAllowDestory($request)
    {
        $role_id = $request->session()->get('role_id');
        if ($role_id == 1) return true;

        $admin_id = $request->session()->get('admin_id');
        $admin = Admin::with('merchant')->where('id', $admin_id)->first();

        $goods = Goods::find($request->goods_id);
        if ($goods->merchant_id != $admin->merchant->id) {
            throw new ApiException('禁止删除');
        }
        return true;
    }

    // private function _destoryAllCates($goods_id)
    // {
    //     Cate::where('goods_id', $goods_id)->delete();
    // }
    // private function _filterCates($cates, $id)
    // {
    //     $cates = $cates->filter(function ($cate, $key) use ($id) {
    //         return $cate->id != $id;
    //     });
    //     return $cates->values();
    // }
    /**
     * @return array
     */
    private function _resetCates($goods_id)
    {
        $cates = Cate::where('goods_id', $goods_id)->get();
        foreach ($cates as $key => $cate) {
            Cate::where('id', $cate->id)->update(['attr_name' => 'attr' . ($key + 1)]);
        }
    }
    // private function _resetCates($cates)
    // {
    //     $cates = $cates->map(function ($cate, $key) {
    //         $new_cate['merchant_id']  = $cate->merchant_id;
    //         $new_cate['goods_id']     = $cate->goods_id;
    //         $new_cate['name']         = $cate->name;
    //         $new_cate['attr_name']    = 'attr' . ($key + 1);
    //         return $new_cate;
    //     });
    //     return $cates;
    // }

    private function _insertNewCates($cates)
    {
        Cate::insert($cates->toArray());
    }

    /**
     *  删除属性值
     */
    public function destoryVal(Request $request)
    {
        CateVal::where('id', $request->id)->delete();
        return response()->api();
    }


}
