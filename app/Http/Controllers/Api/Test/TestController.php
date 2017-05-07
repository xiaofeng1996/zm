<?php

namespace App\Http\Controllers\Api\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $this->apiValidate($request, [
            'name' => 'required'
        ]);
    }
}
