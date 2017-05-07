<?php

namespace Repositories\Api\Goods;

use Entities\Collect;
use Carbon\Carbon;

class CollectRepository 
{
    public function collectSwitch($user_id, $goods_id)
    {
        $collect = Collect::where([
            ['user_id', $user_id],
            ['goods_id', $goods_id]
        ])->first();

        if ($collect) {
            Collect::where([
                ['user_id', $user_id],
                ['goods_id', $goods_id]
            ])->delete();
        } else {
            Collect::insert([
                'user_id' => $user_id,
                'goods_id' => $goods_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        return ;

    }
}
