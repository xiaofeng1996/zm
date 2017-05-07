<?php

namespace Repositories\Api\Auth;

use Repositories\UserRepository;
use Hash;
use Entities\User;

class RegisterRepository extends UserRepository 
{
    public function create($data)
    {
        if ($this->getUserByMobile($data['mobile'])) {
            throw new \Exception('该手机号已注册');
        }
        $user = User::create([
           'mobile' => $data['mobile'],
           'name' => $data['mobile'],
           'avatar' => '/images/face_small.jpg',
           'password' => Hash::make($data['password']),
           'province' => $data['province'],
           'city' => $data['city'],
           'district' => $data['district']
        ]);

        if ($user) {
            return $user;
        } else {
            throw new \Exception('注册失败, 稍后重试');
        }
    }
}
