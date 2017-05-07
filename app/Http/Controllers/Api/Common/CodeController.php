<?php

namespace App\Http\Controllers\Api\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CodeController extends Controller
{
    public function send(Request $request)
    {
        $this->apiValidate($request, [
            'mobile' => 'required'
        ]);
        $codeSrv = resolve('Code\CodeService');
        if ($codeSrv->send($request->mobile, $request->getClientIp())) {
            return response()->api();
        }
    }
}
