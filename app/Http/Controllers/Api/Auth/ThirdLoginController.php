<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Auth\ThirdLoginRepository as Login;
use JWTAuth;

class ThirdLoginController extends Controller
{
    public function index(Request $request, Login $login)
    {
        $this->apiValidate($request, [
            'logtype' => 'required|integer',
            'openid' => 'required_if:logtype,1',
            'weiboid' => 'required_if:logtype,2',
            'qqOpenid' => 'required_if:logtype,3',
            'device' => 'required|integer'
        ]);

        $user = $login->login($request->all());
        $user->token = JWTAuth::fromUser($user);
        return response()->api($user);
    }
}
