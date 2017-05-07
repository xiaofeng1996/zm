<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;

class TokenController extends Controller
{
    public function refresh(Request $request)
    {
        $this->apiValidate($request, [
            'token' => 'required'
        ]);
        $token = JWTAuth::refresh($request->token);
        return response()->api(['token' => $token]);
    }
}
