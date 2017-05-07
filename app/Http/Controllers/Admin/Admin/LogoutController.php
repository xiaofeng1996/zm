<?php

namespace App\Http\Controllers\Admin\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function index(Request $request)
    {
        $request->session()->flush();
        return response()->api();
    }
}
