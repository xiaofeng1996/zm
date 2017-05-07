<?php

namespace Repositories\Web\Auth;

use Entities\User;
use Hash;
use Redirect;

class LoginRepository 
{
    public function login($request)
    {
        $user = $this->getUserByMobile($request->mobile);
        if ($user) {
            if ($this->checkPassword($user, $request->password)) {
                $request->session()->put('user_id', $user->id);
                return redirect('/');
            } else {
                $request->session()->flash('login_err', '密码错误');
                return redirect('/')->withInput();
            }
        } else {
            $request->session()->flash('login_err', '手机号未注册');
            return redirect('/')->withInput();
        }
    }

    private function getUserByMobile($mobile)
    {
        $user = User::where('mobile', $mobile)->first();
        return $user;
    }

    private function checkPassword($user, $password)
    {
        return Hash::check($password, $user->password) ? true : false;
    }
}
