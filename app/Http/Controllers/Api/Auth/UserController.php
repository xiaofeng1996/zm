<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Auth\UserInforRepository as UserRsp;

class UserController extends Controller
{
    /**
     * 获取用户信息
     */
    public function index(Request $request, UserRsp $userRsp)
    {
        $user = $userRsp->getUserById($request->userId);
        return response()->api($user);
    }

    public function update(Request $request, UserRsp $userRsp)
    {
        $this->apiValidate($request, [
            'name' => 'required'
        ]);

        $userRsp->update($request->except('token'), $request->userId);
        return response()->api();        

    }

    public function bindMobile(Request $request, UserRsp $userRsp)
    {
        $this->apiValidate($request, [
            'mobile' => 'required',
            'code' => 'required'
        ]);

        $userRsp->bindMobile($request->mobile, $request->userId);
        return response()->api();

    }

}
