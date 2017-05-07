<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(20);
        return response()->api($users);
    }

    public function getRole(Request $request)
    {
        $role_id = $request->session()->get('role_id');
        return response()->api(['role_id' => $role_id]);
    }
}
