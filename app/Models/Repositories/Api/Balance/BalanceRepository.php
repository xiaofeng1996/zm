<?php

namespace Repositories\Api\Balance;

use Repositories\BalanceBaseRepository;
use Entities\User;
use Entities\Recharge;
use Entities\BalanceRecord;
use Entities\Pay;
use Entities\Contact;
use DB;
use Carbon\Carbon;

class BalanceRepository extends BalanceBaseRepository
{
    private $recharge_money = 200;
    public function createRecharge($user_id, $mobile)
    {
        $user = User::find($user_id);
        if ($user->mobile == $mobile) {
            throw new \Exception('不能填写自己的手机号');
        }

        $invite_user = User::where('mobile', $mobile)->first();

        $recharge = null;
        DB::transaction(function () use ($user_id, $invite_user, $mobile, &$recharge) {
            $this->addContactRecord($user_id, $invite_user, $mobile);
            $recharge_id = $this->insertRechargeGetId($user_id, $invite_user, $mobile);
            $recharge = $this->createAndInsertOutTradeNo($recharge_id);
        });
        
        return $recharge;

    }

    private function insertRechargeGetId($user_id, $invite_user, $mobile)
    {
        $recharge_id = Recharge::insertGetId([
            'user_id' => $user_id, 
            'invite_mobile' => $mobile ? $mobile : '', 
            'invite_user_id' => $invite_user ? $invite_user->id : 0,
            'total_money' => $this->recharge_money,
            'status' => 0, 
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        return $recharge_id;
    }

    private function createAndInsertOutTradeNo($recharge_id)
    {
        $recharge = Recharge::find($recharge_id);
        $out_trade_no = 'CZ' . time() . $recharge_id;
        $recharge->out_trade_no = $out_trade_no;
        $recharge->save();
        return $recharge;
    }

    private function addContactRecord($user_id, $invite_user, $mobile)
    {
        if ($mobile) {
            Contact::insert([
                'user_id' => $user_id, 
                'invite_user_id' => $invite_user ? $invite_user->id : 0,
                'invite_user_name' => $invite_user ? $invite_user->name : '',
                'invite_user_mobile' => $mobile ? $mobile : '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }

    // ------------------------------------- 华丽丽的分割线 ---------------------------------------

    // 充值成功
    public function rechargeSucc($out_trade_no, $total_fee, $trade_no, $pay_type, $fee_type)
    {
        $recharge = Recharge::where('out_trade_no', $out_trade_no)->first();
        if ($recharge->status == 0) {
            $this->chgRechargeStatus($recharge);
            $this->addPayRecord($recharge, $trade_no, 1, $pay_type, $fee_type);
            $this->addBalanceRecord($recharge->user_id, 2, 1, $recharge->total_money, '充值');
            $this->chgUserShopBalance($recharge->user_id, $recharge->total_money);
        } 
    }

    private function chgRechargeStatus($recharge)
    {
        $recharge->status = 1;
        $recharge->updated_at = Carbon::now();
        $recharge->save();
    }

    private function addPayRecord($recharge, $trade_no, $pay_device, $pay_type, $fee_type)
    {
        Pay::insert([
            'user_id' => $recharge->user_id, 
            'trade_no' => $trade_no,
            'money' => $recharge->total_money,
            'pay_device' => $pay_device,
            'pay_type' => $pay_type,
            'fee_type' => $fee_type,
            'created_at' => Carbon::now(),
            'keytype' => 2, 
            'keyid' => $recharge->id
        ]);
    }

    private function addBalanceRecord($user_id, $type, $chg_type, $money, $desc)
    {
        $money_str = ['1' => '+' . $money, '2' => '-' . $money];
        BalanceRecord::insert([
            'user_id' => $user_id, 
            'type' => $type,
            'chg_type' => $chg_type,
            'money' => $money,
            'money_str' => $money_str[$chg_type],
            'desc' => $desc,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    private function chgUserShopBalance($user_id, $money)
    {
        User::where('id', $user_id)->increment('shop_balance', $money);
    }

}