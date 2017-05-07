<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Auth\PasswordRepository as Password;
use JWTAuth;

class PasswordController extends Controller
{
    // 找回密码
    public function index(Request $request, Password $password)
    {
        $this->apiValidate($request, [
            'mobile' => 'required',
            'code' => 'required|numeric',
            'password' => 'required',
            'rePassword' => 'required|same:password'
        ]);

        $user = $password->find($request->all());
        $user->token = JWTAuth::fromUser($user);
        return response()->api($user);

    }

    //
    public function reset(Request $request, Password $password)
    {
        $this->apiValidate($request, [
            'oldPassword' => 'required',
            'newPassword' => 'required',
            'reNewPassword' => 'required|same:newPassword'
        ]);

        $password->reset($request->except(['token', 'reNewPassword']), $request->userId);
        return response()->api();

    }

    public function payPasswordReset(Request $request, Password $password)
    {
        $this->apiValidate($request, [
            'mobile' => 'required',
            'code' => 'required',
            'payPassword' => 'required',
            'rePayPassword' => 'required|same:payPassword'
        ]);
        
        $password->payPasswordReset($request->all(), $request->userId);
        return response()->api();

    }

}
