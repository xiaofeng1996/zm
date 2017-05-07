<?php

namespace App\Http\Controllers\Api\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Entities\Config;

class InitController extends Controller
{
    public function index (Request $request)
    {
        $currentVersion = $request->input('currentVersion');
        $device = $request->input('device');

        return response()->api([
            'host' => env('APP_URL') ,
            'fileRoot' => env('APP_FILE_URL'),
            'lastVersion' => config('update.version'),
            'adUpdateUrl' => config('update.ad_update_url'),
            'adMustUpdate' => config('update.ad_must_update'),
            'iosUpdateUrl' => config('update.ios_update_url'),
            'iosMustUpdate' => config('update.ios_must_update'),
            'wechatLogin' => config('update.wechat_login'),
            'guide' => env('APP_URL') . '/api/guide',
            'regAgreement' => env('APP_URL') . '/api/agreement',
            'aboutUs' => env('APP_URL') . '/api/aboutUs',
            'rule' => env('APP_URL') . '/api/rule',
            'balance_refer' => env('APP_URL') . '/api/balance_refer',
            'cash_rate' => $this->getCashRate()
        ]);
    }

    private function getCashRate()
    {
        $cash_rate = config::where('config_key', 'cash_rate')->value('config_value');
        $cash_rate = $cash_rate ? $cash_rate . '%' : '5%';
        return $cash_rate;
    }
}
