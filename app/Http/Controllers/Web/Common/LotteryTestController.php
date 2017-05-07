<?php

namespace App\Http\Controllers\Web\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LotteryTestController extends Controller
{
    public function index()
    {
        $lottery = resolve('Lottery\LotteryService');
        $lottery->saveLotteries();
    }
}
