<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Auth\ThirdRegisterRepository as Register;
use JWTAuth;

class ThirdRegisterController extends Controller
{
    public function index(Request $request, Register $register)
    {
        $this->apiValidate($request, [
            'logtype' => 'required|integer',
            'name' => 'required|string',
            'avatar' => 'required',
            'openid' => 'required_if:logtype,1',
            'unionid' => 'required_if:logtype,1',
            'weiboid' => 'required_if:logtype,2',
            'idstr' => 'required_if:logtype,2',
            'qqOpenid' => 'required_if:logtype,3',
            'mobile' => 'required',
            'code' => 'required',
        ]);
        $user = $register->create($request->all());
        $user->token = JWTAuth::fromUser($user);
        return response()->api($user);
    }
}
