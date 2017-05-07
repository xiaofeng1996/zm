<?php

namespace Repositories\Api\Auth;

use Repositories\UserRepository;
use Entities\User;

class ThirdLoginRepository extends UserRepository 
{
    public function login($data)
    {
        switch ($data['logtype']) {
            case 1:
                $user = $this->getUserByWx($data['openid']);
                break;
            case 2:
                $user = $this->getUserByWb($data['weiboid']);
                break;
            case 3:
                $user = $this->getUserByQQ($data['qqOpenid']);
                break;
            default:
                throw new \Exception('登录方式不正确');
                break;
        }
        if (!$user || !$user->mobile) {
            throw new \Exception('帐号不存在', 404);
        } else {
            return $user;
        }
    }

    // 通过微信获取用户
    private function getUserByWx($openid)
    {
        $user = User::where('openid', $openid)->first();
        return $user;
    }

    // 通过微博获取用户信息
    private function getUserByWb($weiboid)
    {
        $user = User::where('weiboid', $weiboid)->first();
        return $user;
    }

    // 通过 qq 获取用户信息
    private function getUserByQQ($qqOpenid)
    {
        $user = User::where('qq_openid', $qqOpenid)->first();
        return $user;
    }

}
