<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Entities\User;
use Hash;

class ForgotPasswordController extends Controller
{
    public function create(Request $request)
    {
        return view('web.auth.forget_password');
    }

    public function post(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required',
            'password' => 'required',
            're_password' => 'required|same:password',
            'code' => 'required'
        ]);
        $isValid = $this->checkCode($request);
        if ($isValid == 'valid') {
            $user = User::where('mobile', $request->mobile)->first();
            if (!$user) {
                $request->session()->flash('forgot_err', '该手机号未注册');
                return redirect('/forgot/password')->withInput();
            }

            $user->password = Hash::make($request->password);
            $user->save();

            $request->session()->put('user_id', $user->id);
            return redirect('/');
        } else {
            return $isValid;
        }

    }

    private function checkCode($request)
    {
        try {
            $codeSrv = resolve('Code\CodeService');
            $codeSrv->verify($request->mobile, $request->code); 
            return 'valid';
        } catch (\Exception $e) {
            $request->session()->flash('forgot_err', $e->getMessage());
            return redirect('/forgot/password')->withInput();
        }
    }

}
