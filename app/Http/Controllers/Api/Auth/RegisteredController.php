<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\User;

class RegisteredController extends Controller
{
    public function index(Request $request)
    {
        $this->apiValidate($request, [
            'mobile' => 'required'
        ]);
        $user = User::where('mobile', $request->mobile)->first();
        return $user ? response()->api(['isRegistered' => '1']) 
                     : response()->api(['isRegistered' => '0']);
    }
}
