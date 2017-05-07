<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Auth\LoginRepository as Login;
use JWTAuth;

class LoginController extends Controller
{
    public function index(Request $request, Login $login)
    {
        $this->apiValidate($request, [
            'mobile' => 'required',
            'password' => 'required'
        ]);      

        $user = $login->login($request->all());
        $user->token = JWTAuth::fromUser($user);
        return response()->api($user);
    }

}
