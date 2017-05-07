<?php

namespace App\Http\Controllers\Admin\Bussiness;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Entities\Merchant;
use Entities\Admin;
use Hash;
use Carbon\Carbon;
use App\Exceptions\ApiException;

class MerchantController extends Controller
{
    public function index(Request $request)
    {
        $merchants = Merchant::where(function ($query) use ($request) {
                                $role_id = $request->session()->get('role_id');
                                $admin_id = $request->session()->get('admin_id');
                                if ($role_id == 2) {
                                    $query->where('admin_id', $admin_id);
                                }
                            })
                            ->paginate(20);
        return response()->api($merchants);
    }

    public function getMerchantsAll()
    {
        $merchants = Merchant::get();
        return response()->api($merchants);
    }

    public function store(Request $request)
    {
        if ($request->session()->get('role_id') == 2 && !$request->input('id')) {
            throw new ApiException('没有权限');
        }

        $this->apiValidate($request, [
            'name'          => 'required',
            'mobile'        => 'required',
            'province'      => 'required',
            'city'          => 'required',
            'district'      => 'required',
            'address'       => 'required',
            'fare'          => 'required|numeric'
        ]);
        try {
            DB::transaction(function () use ($request) {
                $admin_id = $this->getAdminId($request);
                $this->storeMerchant($request, $admin_id);
            });
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }
        return response()->api();
    }

    private function storeMerchant($request, $admin_id)
    {
        $merchant = $request->id
                    ? Merchant::find($request->id)
                    : new Merchant;

        $merchant->name         = $request->name;
        $merchant->mobile       = $request->mobile;
        $merchant->image        = $request->image;
        $merchant->province     = $request->province;
        $merchant->city         = $request->city;
        $merchant->district     = $request->district;
        $merchant->address      = $request->address;
        $merchant->fare         = $request->fare;
        $merchant->admin_id     = $admin_id;

        return $merchant->save();

    }

    private function getAdminId($request)
    {
        $admin = Admin::where('mobile', $request->mobile)->first();
        if ($admin && !$request->id) {
            throw new ApiException('手机号已被使用');
        }
        if (!$admin) {
            $admin = new Admin;
            $admin->mobile      = $request->mobile;
            $admin->password    = Hash::make($request->mobile);
            $admin->created_at  = Carbon::now();
            $admin->updated_at  = Carbon::now();
            $admin->role_id     = 2;
            $admin->save();
        }
        return $admin->id;
    }

    public function delete(Request $request)
    {
        Merchant::where('id', $request->id)->delete();
        return response()->api();
    }
}
