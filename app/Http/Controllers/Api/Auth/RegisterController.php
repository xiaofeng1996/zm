<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Auth\RegisterRepository as Register;
use Carbon\Carbon;
use JWTAuth;

class RegisterController extends Controller
{
    public function index(Request $request, Register $register)
    {
        $this->apiValidate($request, [
            'mobile' => 'required',
            'code' => 'required|numeric',
            'password' => 'required',
            'rePassword' => 'same:password',
            'device' => 'required'
        ]);
        $user = $register->create($request->input());
        $user->token = JWTAuth::fromUser($user);
        return response()->api($user);
    }
}
