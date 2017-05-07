<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\User;
use Hash;

class PayPasswordController extends Controller
{
    public function create()
    {
        return view('web.auth.set_pay_password');
    }
    public function save(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required',
            'code' => 'required',
            'password' => 'required',
            're_password' => 'required|same:password'
        ]);
        try {
            $this->checkCode($request);
        } catch (\Exception $e) {
            $request->session()->flash('set_err', $e->getMessage());
            return redirect('/pay_password/create');
        }
        $user_id = $request->session()->get('user_id');
        $user = User::find($user_id);
        if ($user->mobile != $request->mobile) {
            $request->session()->flash('set_err', '手机号与登录帐号不匹配');
            return redirect('/pay_password/create');
        }
        $user->pay_password = Hash::make($request->password);
        $user->save();
        return redirect('/account');
    }

    private function checkCode($request)
    {
        $codeSrv = resolve('Code\CodeService');
        $codeSrv->verify($request->mobile, $request->code);
    }
}
