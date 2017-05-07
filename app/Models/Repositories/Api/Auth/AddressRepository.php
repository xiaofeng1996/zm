<?php

namespace Repositories\Api\Auth;

use Entities\Address;
use Entities\User;
use DB;

class AddressRepository 
{
    public function getAddresses($userId)
    {
        $user = User::find($userId);
        $address = $user->address()
                        ->orderBy('is_default', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->get();
        return $address;
    }

    public function create($data, $userId)
    {
        try {
            $user = User::find($userId);
            $isDefault = ($user->address()->count() > 0) ? 0 : 1;
            $user->address()->create([
                'user_id' => $userId,
                'name' => $data['name'],
                'mobile' => $data['mobile'],
                'province' => $data['province'],
                'city' => $data['city'],
                'district' => $data['district'],
                'address' => $data['address'],
                'is_default' => $isDefault,
            ]);
        } catch (\Exception $e) {
            throw new \Exception('地址保存失败, 稍后重试');
        }
    }

    public function update($data, $userId)
    {
        try {
            $address = Address::where([
                ['id', $data['id']], 
                ['user_id', $userId]
            ])->first();
            $address->name = $data['name'];
            $address->mobile = $data['mobile'];
            $address->province = $data['province'];
            $address->city = $data['city'];
            $address->district = $data['district'];
            $address->address = $data['address'];

            $address->save();
            return ;
        } catch (\Exception $e) {
            throw new \Exception('操作失败, 稍后重试');
        }
    }

    public function destroy($id, $userId)
    {
        try {
            Address::where([
                ['id', $id],
                ['user_id', $userId]
            ])->delete();
            return ;
        } catch (\Exception $e) {
            throw new \Exception('操作失败, 稍后重试');
        }
    }

    public function setDefault($id, $userId)
    {
        try {
            DB::transaction(function () use ($id, $userId) {
                Address::where([
                    ['user_id', $userId],
                    ['is_default', 1]
                ])->update(['is_default' => 0]);

                Address::where([
                    ['user_id', $userId],
                    ['id', $id]
                ])->update(['is_default' => 1]);
            });
        } catch (\Exception $e) {
            throw new \Exception('操作失败, 稍后重试');
        }
    }


}
