<?php

namespace App\Http\Controllers\Admin\Lottery;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\Lottery;

class LotteryController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $lotteries = Lottery::orderBy('opentimestamp', 'desc')
                            ->where(function ($query) use ($params) {
                                if (isset($params['expect']) && $params['expect']) {
                                    $query->where('expect', 'like', '%' . $params['expect'] . '%');
                                }
                            })
                            ->paginate();
        return response()->api($lotteries);
    }
}
