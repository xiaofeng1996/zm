<?php

namespace Repositories\Api\Auth;

use Repositories\UserRepository;
use Entities\User;

class UserInforRepository extends UserRepository 
{
    public function update($data, $userId)
    {
        User::where('id', $userId)->update([
            'name' => $data['name']
        ]);
        return ;
    }

    public function bindMobile($mobile, $userId)
    {
        $user = $this->getUserByMobile($mobile);
        if ($user) {
            throw new \Exception('该手机号已绑定其他帐号');
        } else {
            User::where('id', $userId)->update([
                'mobile' => $mobile
            ]);
        }
    }
}
