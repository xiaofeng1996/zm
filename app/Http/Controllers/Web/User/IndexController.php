<?php

namespace App\Http\Controllers\Web\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\User;

class IndexController extends Controller
{
    public function detail(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $user = User::find($user_id);
        if (!$user) {
            abort(404);
        }
        return view('web.user.detail')->with('user', $user);
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $user_id = $request->session()->get('user_id');
        $user = User::find($user_id);
        if (!$user) {
            abort(404);
        }
        $user->name = $request->name;
        if ($request->hasFile('avatar')) {
            $user->avatar = $this->storeFile($request, 'avatar');
        }
        $user->save();
        return view('web.user.detail')->with('user', $user);
    }
}
