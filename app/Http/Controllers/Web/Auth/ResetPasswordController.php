<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use Entities\User;
use Hash;

class ResetPasswordController extends Controller
{
    private function selfValidate($request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required',
            're_new_password' => 'required|same:new_password'
        ]);
        return $validator;
    }
    public function save(Request $request)
    {
        $validator = $this->selfValidate($request);
        if ($validator->fails()) {
            return redirect('/user#safe')
                ->withErrors($validator)
                ->withInput();
        }
        $user_id = $request->session()->get('user_id');
        $user = User::find($user_id);
        if (!Hash::check($request->old_password, $user->password)) {
            $request->session()->flash('reset_err', '原密码不正确');
            return redirect('/user#safe');
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect('/user');
    }
}
