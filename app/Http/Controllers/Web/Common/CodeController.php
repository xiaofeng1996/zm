<?php

namespace App\Http\Controllers\Web\Common;

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
        } else {
            return response()->api('发送失败', 0);
        }
    }
}
