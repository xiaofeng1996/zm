<?php

namespace App\Http\Controllers\Admin\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\Admin;
use Hash;

class ResetPasswordController extends Controller
{
    public function store(Request $request)
    {
        $this->apiValidate($request, [
            'mobile'        => 'required',
            'old_password'  => 'required',
            'password'      => 'required',
            're_password'   => 'required|same:password'
        ]);
        $admin_id = $request->session()->get('admin_id');
        $admin = Admin::find($admin_id);

        if (!$admin) {
            return response()->api('管理员不存在', 0);
        }

        if ($admin->mobile != $request->mobile) {
            return response()->api('手机号不正确', 0);
        }

        if (!Hash::check($request->old_password, $admin->password)) {
            return response()->api('原密码错误', 0);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        return response()->api();

    }
}
