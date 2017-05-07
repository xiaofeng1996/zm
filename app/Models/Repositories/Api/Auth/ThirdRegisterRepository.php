<?php

namespace Repositories\Api\Auth;

use Repositories\UserRepository;
use Entities\User;
use Hash;

class ThirdRegisterRepository extends UserRepository 
{
    public function create($data)
    {
        switch ($data['logtype']) {
            case 1:
                $user = $this->createByWx($data);
                break;
            case 2:
                $user = $this->createByWb($data);
                break;
            case 3:
                $user = $this->createByQQ($data);
                break;
            default:
                throw new \Exception('注册方式不正确');
                break;
        }
        return $user;
    }

    // 通过微信获取用户
    private function createByWx($data)
    {
        $user = $this->getUserByMobile($data['mobile']);
        if ($user && $user->openid) {
            throw new \Exception('手机号已绑定其他帐号');
        } else if ($user){
            $user->openid = $data['openid'];
            $user->unionid = $data['unionid'];
            $user->save();
        } else {
            $user = User::create([
                'name' => $data['name'],
                'mobile' => $data['mobile'],
                'avatar' => $data['avatar'],
                'openid' => $data['openid'],
                'unionid' => $data['unionid'],
                'password' => Hash::make($data['password']),
                'province' => $data['province'],
                'city' => $data['city'],
                'district' => $data['district'],
                'device' => $data['device'],
            ]);
        }
        return $user;
    }

    // 通过微博获取用户信息
    private function createByWb($data)
    {
        $user = $this->getUserByMobile($data['mobile']);
        if ($user && $user->weiboid) {
            throw new \Exception('手机号已绑定其他帐号');
        } else if ($user){
            $user->weiboid = $data['weiboid'];
            $user->idstr = $data['idstr'];
            $user->save();
        } else {
            $user = User::create([
                'name' => $data['name'],
                'mobile' => $data['mobile'],
                'avatar' => $data['avatar'],
                'weiboid' => $data['weiboid'],
                'idstr' => $data['idstr'],
                'password' => Hash::make($data['password']),
                'province' => $data['province'],
                'city' => $data['city'],
                'district' => $data['district'],
                'device' => $data['device'],
            ]);
        }
        return $user;
    }

    // 通过 qq 获取用户信息
    private function createByQQ($data)
    {
        $user = $this->getUserByMobile($data['mobile']);
        if ($user && $user->qq_openid) {
            throw new \Exception('手机号已绑定其他帐号');
        } else if ($user){
            $user->mobile = $data['mobile'];
            $user->save();
        } else {
            $user = User::create([
                'name' => $data['name'],
                'mobile' => $data['mobile'],
                'avatar' => $data['avatar'],
                'qq_openid' => $data['qqOpenid'],
                'password' => Hash::make($data['password']),
                'province' => $data['province'],
                'city' => $data['city'],
                'district' => $data['district'],
                'device' => $data['device'],
            ]);
        }
        return $user;
    }

}
