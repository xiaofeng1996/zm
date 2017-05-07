<?php

namespace Repositories;

use Carbon\Carbon;
use Entities\BalanceRecord as Balance;

class BalanceBaseRepository 
{
    public function getList($user_id, $type)
    {
        $list = Balance::where([
            ['user_id', $user_id],
            ['type', $type]
        ])
        ->orderBy('created_at', 'desc')
        ->paginate(20);
        return $list ? page_helper($list) : [];
    }

}