<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use Entities\Bank;

class UnionController extends Controller
{
    public function create()
    {
        $banks = Bank::get();
        return view('web.user.account.union')->with('banks', $banks);
    }
}
