<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Repositories\Web\Auth\LoginRepository as Login;

class LoginController extends Controller
{

    public function login (Request $request, Login $login)
    {
        $this->validate($request, [
            'mobile' => 'required',
            'password' => 'required'
        ]);
        $redirect = $login->login($request);
        return $redirect;
    }
}
