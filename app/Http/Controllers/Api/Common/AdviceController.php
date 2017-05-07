<?php

namespace App\Http\Controllers\Api\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Common\AdviceRepository as Advice;

class AdviceController extends Controller
{
    public function create(Request $request, Advice $advice)
    {
        $this->apiValidate($request, [
            'content' => 'required|max:225',
            'device' => 'required'
        ]);
        $advice->create($request->all());
        return response()->api();
    }
}
