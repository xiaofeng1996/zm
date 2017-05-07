<?php

namespace App\Http\Controllers\admin\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Admin\Admin\LoginRepository as Login;

class LoginController extends Controller
{
    public function login(Request $request, Login $login)
    {
        $this->apiValidate($request, [
            'mobile' => 'required',
            'password' => 'required'
        ]);
        $login->login($request);
        return response()->api();
    }

    public function isLogin(Request $request)
    {
        if ($request->session()->get('admin_id') > 0) {
            return response()->api();
        } else {
            return response()->api('未登录', 0);
        }
    }
}
