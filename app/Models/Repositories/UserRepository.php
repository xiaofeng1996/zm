<?php

namespace Repositories;

use Entities\User;
use Entities\OrderLottery;
use Entities\Notice;

class UserRepository 
{
    /**
     * 通过 id 获取用户
     */
    public function getUserById($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $collect = $this->getUserCollectInfo($user);
            $user->collect = $collect;
            $user->is_award = $this->isAward($user->id);
            $user->is_unread_notice = $this->isUnreadNotice($user->id);
        }
        return $user;
    }

    public function getUserByMobile($mobile)
    {
        $user = User::where('mobile', $mobile)->first();
        if ($user) {
            $collect = $this->getUserCollectInfo($user);
            $user->collect = $collect;
            $user->is_award = $this->isAward($user->id);
            $user->is_unread_notice = $this->isUnreadNotice($user->id);
        }
        return $user;
    }

    public function destroyById($id)
    {
        return User::destroy($id);
    }

    // 组合收藏相关的数据
    private function getUserCollectInfo($user)
    {
        $std = new \stdClass();
        $member_collects_count = $user->goodsCollects() 
                                        ->join('goods', function ($join) {
                                            $join->on('collects.goods_id', '=', 'goods.id')
                                                    ->where('is_lucky', 0);
                                        })
                                        ->count();
        $collect_goods = $user->goodsCollects()
                                ->join('goods', function ($join) {
                                    $join->on('collects.goods_id', '=', 'goods.id')
                                            ->where('is_lucky', 0);
                                })
                                ->first();

        $member_collect = new \stdClass();
        $member_collect->count = $member_collects_count;
        $member_collect->image = $collect_goods ? $collect_goods->image : '';
        
        $lucky_collects_count = $user->goodsCollects() 
                                        ->join('goods', function ($join) {
                                            $join->on('collects.goods_id', '=', 'goods.id')
                                                    ->where('is_lucky', 1);
                                        })
                                        ->count();
        $collect_goods = $user->goodsCollects()
                                ->join('goods', function ($join) {
                                    $join->on('collects.goods_id', '=', 'goods.id')
                                            ->where('is_lucky', 1);
                                })
                                ->first();
        $lucky_collect = new \stdClass();
        $lucky_collect->count = $lucky_collects_count;
        $lucky_collect->image = $collect_goods ? $collect_goods->image : '';

        $std->member_collect = $member_collect;
        $std->lucky_collect = $lucky_collect;

        return $std;
    }

    // 检查是否还有未浏览的中奖纪录
    private function isAward($user_id)
    {
        $lottery = OrderLottery::where([
            ['user_id', $user_id],
            ['status', 1],
            ['is_glanced', 0]
        ])->first();
        return $lottery ? 1 : 0;
    }

    // 检查是否有未读消息
    private function isUnreadNotice($user_id)
    {
        $notice = Notice::where([
            ['user_id', $user_id],
            ['is_read', 0]
        ])->first();
        return $notice ? 1 : 0;
    }

    // protected function convertFormat($obj)
    // {
    //     return convertObjToStd($obj);      
    // }
}