<?php

namespace App\Http\Controllers\Api\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class WapController extends Controller
{
    // 新手指引
    public function guide()
    {
        $content = $this->getContent('guide');
        return view('api.wap.guide')->with('content', $content);
    }

    // 注册协议
    public function agreement()
    {
        $content = $this->getContent('agreement');
        return view('api.wap.agreement')->with('content', $content);
    }

    // 关于我们
    public function aboutUs()
    {
        $content = $this->getContent('about_us');
        return view('api.wap.aboutUs')->with('content', $content);
    }

    // 幸运区规则
    public function rule()
    {
        $content = $this->getContent('rule');
        return view('api.wap.rule')->with('content', $content);
    }

    // 现金余额说明
    public function balanceRefer()
    {
        $content = $this->getContent('balance_refer');
        return view('api.wap.balance_refer')->with('content', $content);
    }

    private function getContent($type)
    {
        $content = DB::table('htmls')->where('type', $type)->value('content');
        return $content;
    }

}
