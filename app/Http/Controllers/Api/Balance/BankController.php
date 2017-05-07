<?php

namespace App\Http\Controllers\Api\Balance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\Bank;

class BankController extends Controller
{
    public function index() 
    {
        $banks = Bank::orderBy('sort')->get();
        return response()->api($banks);
    }
}
