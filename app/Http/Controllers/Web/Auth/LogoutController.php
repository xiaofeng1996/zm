<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->forget('user_id');
        return redirect('/');
    }
}
