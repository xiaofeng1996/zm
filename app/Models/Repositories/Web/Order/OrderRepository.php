<?php

namespace Repositories\Web\Order;

use Repositories\Base\Order\OrderBaseRepository;
use Entities\Order;
use DB;

class OrderRepository extends OrderBaseRepository
{
    public function getList($user_id, $keytype = 0, $is_lucky = 0)
    {
//        DB::enableQueryLog();
        $list = Order::with('merchant', 'goods', 'lotteries')
            ->where(function ($query) use ($keytype) {
                if ($keytype > 0 && $keytype < 4) {
                    $query->where('status', $keytype);
                } else if ($keytype >= 4) {
                    $query->whereIn('status', [4, 5, 6]);
                }
            })
            ->where('is_lucky', $is_lucky)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
//         dd(DB::getQueryLog());
        return page_helper($list);
    }
}