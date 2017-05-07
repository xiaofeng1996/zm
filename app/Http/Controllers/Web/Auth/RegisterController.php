<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use Entities\User;
use App\Http\Controllers\Controller;
use DB;
use Hash;

class RegisterController extends Controller
{
    public function create()
    {
        $register_rule = $this->getRegisterRule();
        return view('web.auth.register')->with('register_rule', $register_rule);
    }

    public function post(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required',
            'password' => 'required',
            're_password' => 'required|same:password',
            'code' => 'required',
            'province' => 'required',
            'city' => 'required'
        ]);

        $isValid = $this->checkCode($request);
        if ($isValid == 'valid') {
            $user = User::where('mobile', $request->mobile)->first();
            if ($user) {
                $request->session()->flash('reg_err', '该手机号已注册');
                return redirect('/register')->withInput();
            }

            $user_id = User::insertGetId([
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
                'name' => $request->mobile,
                'province' => $request->province,
                'city' => $request->city,
                'district' => $request->district
            ]);
            $request->session()->put('user_id', $user_id);
            return redirect('/');
        } else {
            return $isValid;
        }
    }

    /**
     * 检查短信验证码
     */
    private function checkCode($request)
    {
        try {
            $codeSrv = resolve('Code\CodeService');
            $codeSrv->verify($request->mobile, $request->code);
            return 'valid';
        } catch (\Exception $e) {
            $request->session()->flash('reg_err', $e->getMessage());
            return redirect('/register')->withInput();
        }
    }

    private function getRegisterRule()
    {
        $register_rule = DB::table('htmls')->where('htmlable_type', 'register_rule')->value('content');
        return $register_rule;
    }
}
