<?php

namespace App\Http\Controllers\Web\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\User;
use Entities\BalanceRecord;
use Entities\Contact;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $user = User::find($user_id);

        $shop_balance_records = BalanceRecord::where([
            ['user_id', $user_id],
            ['type', 2]
        ])
        ->orderBy('created_at', 'desc')
        ->limit(50)
        ->get();

        $account_balance_records = BalanceRecord::where([
            ['user_id', $user_id],
            ['type', 1]
        ])
        ->orderBy('created_at', 'desc')
        ->limit(50)
        ->get();

        $contacts = Contact::where('user_id', $user_id)->get();

        return view('web.user.account.index')
                    ->with('user', $user)
                    ->with('shop_balance_records', $shop_balance_records)
                    ->with('account_balance_records', $account_balance_records)
                    ->with('contacts', $contacts);
    }
}
