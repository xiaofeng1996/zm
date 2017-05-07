<?php

namespace Repositories\Api\Auth;

use Repositories\UserRepository;
use Hash;
use Entities\User;

class PasswordRepository extends UserRepository 
{
    public function find($data)
    {
        $user = User::where('mobile', $data['mobile'])->first();
        if (!$user) {
            throw new \Exception('该手机号未注册或被冻结');
        } else {
            $user->password = Hash::make($data['password']);
            $user->save();
            return $user;
        }
    }

    public function reset($data, $userId)
    {
        $user = User::find($userId);
        if ($user && Hash::check($data['oldPassword'], $user->password)) {
            $user->password = Hash::make($data['newPassword']);
            $user->save();
        } else {
            throw new \Exception('原密码不正确');
        }
    }
    
    public function payPasswordReset($data, $userId)
    {
        try {
            User::where('id', $userId)->update([
                'pay_password' => Hash::make($data['payPassword'])
            ]);
            return ;
        } catch (\Exception $e) {
            throw new \Exception('设置失败, 稍后重试');
        }
    }

}
