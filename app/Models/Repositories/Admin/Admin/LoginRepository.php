<?php

namespace Repositories\Admin\Admin;

use Entities\Admin;
use Carbon\Carbon;
use Hash;

class LoginRepository 
{
    public function login($request)
    {
        $admin = $this->getAdmin($request->input('mobile'));
        if ($this->checkPassword($admin, $request->input('password'))) {
            $request->session()->put('admin_id', $admin->id);
            $request->session()->put('role_id', $admin->role_id);
            return true;
        }
    }

    private function getAdmin($mobile)
    {
        $admin = Admin::where('mobile', $mobile)->first();
        if (!$admin) {
            throw new \Exception('管理员不存在');
        }
        return $admin;
    }

    private function checkPassword($admin, $password)
    {
        if (Hash::check($password, $admin->password)) {
            return true;
        } else {
            throw new \Exception('密码不正确');
        }
    }
}
