<?php

namespace App\Http\Controllers\Web\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\Address;
use Carbon\Carbon;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $addrs = Address::where('user_id', $user_id)
                    ->orderBy('is_default', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->get();
        return view('web.user.address.index')->with('addrs', $addrs);
    }

    public function create(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $addr = Address::where([
            ['user_id', $user_id],
            ['id', $request->id]
        ])->first();

        $redirect = redirect()->back()->getTargetUrl();
        if ($addr) {
            return view('web.user.address.create')->with('addr', $addr)->with('redirect', $redirect);
        } else {
            return view('web.user.address.create')->with('redirect', $redirect);
        }
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'mobile' => 'required',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'address' => 'required',
        ]);
        if ($request->id) {
            $result = $this->_update($request);
        } else {
            $result = $this->_create($request);
        }
        if (!$result) {
            return redirect()->back();
        } else {
            $redirect = $request->redirect ? $request->redirect : '/addrs';
            return redirect($redirect);
        }
    }

    private function _update($request)
    {
        $user_id = $request->session()->get('user_id');
        $addr = Address::where([
            ['user_id', $user_id],
            ['id', $request->id]
        ])->first();
        if (!$addr) {
            $request->session()->flash('save_err', '地址信息不存在');
            return false;
        }
        $addr->name = $request->name;
        $addr->mobile = $request->mobile;
        $addr->province = $request->province;
        $addr->city = $request->city;
        $addr->district = $request->district;
        $addr->address = $request->address;
        $addr->zipcode = $request->zipcode;
        $addr->updated_at = Carbon::now();

        if (!$addr->save()) {
            $request->session()->flash('save_err', '保存失败, 稍后重试');
            return false;
        }
        return true;
    }

    private function _create($request)
    {
        $user_id = $request->session()->get('user_id');
        $addrs_count = Address::where('user_id', $user_id)->count();
        if ($addrs_count >= 3) {
            $request->session()->flash('save_err', '收货地址不能超过3个');
            return false;
        }
        $is_default = $addrs_count > 0 ? 0 : 1;
        $result = Address::insert([
            'user_id' => $user_id,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'address' => $request->address,
            'zipcode' => $request->zipcode,
            'is_default' => $is_default,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        if (!$result) {
            $request->session()->flash('save_err', '保存失败, 稍后重试');
            return false;
        }
        return true;
    }

    public function delete(Request $request)
    {
        $this->apiValidate($request, [
            'id' => 'required|integer'
        ]);
        $user_id = $request->session()->get('user_id');
        Address::where([
            ['user_id', $user_id],
            ['id', $request->id]
        ])->delete();
        return response()->api();
    }
    public function setDefault(Request $request)
    {
        $this->apiValidate($request, [
            'id' => 'required|integer'
        ]);
        $user_id = $request->session()->get('user_id');
        Address::where('user_id', $user_id)->update(['is_default' => 0]);
        Address::where([
            ['user_id', $user_id],
            ['id', $request->id]
        ])->update([
            'is_default' => 1
        ]);
        return response()->api();
    }
}
