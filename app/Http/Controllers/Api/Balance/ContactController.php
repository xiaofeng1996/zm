<?php

namespace App\Http\Controllers\Api\Balance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Balance\ContactRepository as Contact;

class ContactController extends Controller
{
    public function index(Request $request, Contact $contact)
    {
        $list = $contact->getList($request->userId);
        return response()->api($list);
    }
}
