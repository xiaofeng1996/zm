<?php

namespace Repositories\Api\Auth;

use Repositories\UserRepository;
use Hash;
use Entities\User;

class LoginRepository extends UserRepository 
{
    public function login($data)
    {
        $user = User::where('mobile', $data['mobile'])->first();
        if (!$user) {
            throw new \Exception('该手机号未注册或被冻结');
        } else if (!Hash::check($data['password'], $user->password)) {
            throw new \Exception('密码不正确');
        } else {
            return $user;
        }
    }
}
