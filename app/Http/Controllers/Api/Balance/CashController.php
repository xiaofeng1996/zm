<?php

namespace App\Http\Controllers\Api\Balance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Balance\CashRepository as Cash;

class CashController extends Controller
{
    public function cash(Request $request, Cash $cash)
    {
        $this->apiValidate($request, [
            'apply_type' => 'required|integer|min:1|max:2',
            'ali_account' => 'required_if:apply_type,2',
            'bank_name' => 'required_if:apply_type,1',
            'bank_card_no' => 'required_if:apply_type,1',
            'bank_user_name' => 'required_if:apply_type,1',
            'money' => 'required'
        ]);
        $cash->cash($request->userId, $request->input());
        return response()->api();
    }
}
