<?php

namespace App\Http\Controllers\Api\Lottery;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CollectController extends Controller
{
    public function collect()
    {
        $lottery = resolve('Lottery\LotteryService');
        $lottery->saveLotteries();
    }
}