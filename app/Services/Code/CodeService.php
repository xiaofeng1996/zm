<?php

namespace app\Services\Code;

use App\Services\Code\CodeException;
use Entities\Code;
use Carbon\Carbon;

class CodeService
{
    private $table = 'codes';
    private $allowResendTime = 0;
    private $alived = 600;

    public function __construct()
    {
    }

    // 发送验证码
    public function send($mobile, $ip)
    {
        if (!$mobile) {
            throw new CodeException('手机号不能为空');
        }

        if ($this->allowSend($mobile)) {
            $code = $this->createCode($mobile);    
            $this->setCode($mobile, $code, $ip);
            // 发送逻辑....
            return true;
        }
    }

    // 验证
    public function verify($mobile, $code)
    {
        $lastCode = $this->getLastCode($mobile);        
        if (!$lastCode) {
            throw new CodeException('请先发送验证码');
        } else if ($lastCode->is_used || $lastCode->expired_at <= Carbon::now()->subSeconds($this->allowResendTime)) {
            throw new CodeException('验证码已失效');
        } else if ($lastCode->code != $code) {
            $this->dropCode($lastCode);
            throw new CodeException('验证码不正确, 请重新发送');
        } else {
            $this->dropCode($lastCode);
            return true;
        }
    }
    
    // 检查是否允许发送
    private function allowSend($mobile)
    {
        $lastCode = $this->getLastCode($mobile);
        if ($lastCode && !$lastCode->is_used && $lastCode->created_at > Carbon::now()->subMinutes($this->allowResendTime)) {
            throw new CodeException('发送过于频繁');
        } else {
            return true;
        }
    }

    // 生成短信验证码
    private function createCode($mobile)
    {
        $this->dropCode($this->getLastCode($mobile)); //使之前发送的验证码失效
        if (env('APP_DEBUG')) {
            $code = '1234';
        } else {
            $code = rand(1000, 9999);
        }
        return $code;
    }

    // 保存验证码
    private function setCode($mobile, $code, $ip = '')
    {
        Code::insert([
            'mobile' => $mobile,
            'code' => $code,
            'is_used' => 0,
            'ip' => $ip,
            'created_at' => Carbon::now(),
            'expired_at' => Carbon::now()->addSeconds($this->alived)
        ]);
    }

    // 获取最新验证码
    private function getLastCode($mobile)
    {
        $lastCode = Code::where([['mobile', $mobile], ['is_used', 0]])->orderBy('created_at', 'desc')->first();
        return $lastCode;
    }

    /** 
     * 废除验证码
     * @param object $code
     */
    private function dropCode($codeObj)
    {
        if ($codeObj) {
            $codeObj->is_used = 1;
            $codeObj->save();
        }
    }

}