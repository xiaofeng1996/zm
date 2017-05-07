<?php

namespace App\Http\Controllers\Web\User;

use App\Exceptions\ApiException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\User;
use Repositories\Web\Balance\CashRepository as Cash;

class CashController extends Controller
{
    public function create(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $user = User::find($user_id);
        return view('web.user.account.cash')->with('user', $user);
    }

    public function cash(Request $request, Cash $cash)
    {
        $this->apiValidate($request, [
            'apply_type' => 'required|integer', // 1. 银行卡提现, 2:支付宝提现
            'ali_account' => 'required_if:apply_type,2',
            'bank_name' => 'required_if:apply_type,1',
            'bank_card_no' => 'required_if:apply_type,1',
            'bank_user_name' => 'required_if:apply_type,1',
            'money' => 'required|numeric|min:1',
            'pay_password' => 'required'
        ]);

        $user_id = $request->session()->get('user_id');
        try {
            $cash->cash($user_id, $request->all());
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }

        return response()->api();

    }
}
