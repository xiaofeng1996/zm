<?php

namespace Repositories;

use Entities\Cash;
use Entities\User;
use Entities\BalanceRecord;
use Entities\Config;
use Carbon\Carbon;
use DB;
use Hash;

class CashBaseRepository 
{
    public function cash($user_id, $data)
    {
        DB::transaction(function () use($user_id, $data) {
            $pay_password = isset($data['pay_password']) ? $data['pay_password'] : '';
            $this->addApplyRecord($user_id, $data);
            $this->reduceUserAccountBalance($user_id, $data['money'], $pay_password);
            $this->addBalanceRecord($user_id, $data['money']);
        });
    }

    private function addApplyRecord($user_id, $data)
    {
        $cash_rate = $this->getCashRate();
        Cash::insert([
            'user_id' => $user_id, 
            'apply_type' => $data['apply_type'],
            'ali_account' => $data['ali_account'] ? $data['ali_account'] : '',
            'bank_name' => $data['bank_name'] ? $data['bank_name'] : '',
            'bank_card_no' => $data['bank_card_no'] ? $data['bank_card_no'] : '',
            'bank_user_name' => $data['bank_user_name'] ? $data['bank_user_name'] : '',
            'money' => $data['money'],
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'cash_rate' => $cash_rate,
            'processing_fee' => formatMoney(($data['money'] * $cash_rate) / 100)
        ]);
    }

    private function reduceUserAccountBalance($user_id, $money, $pay_password = '')
    {
        $user = User::find($user_id);
        $this->checkPayPassword($user, $pay_password);
        if ($user->account_balance < $money) {
            throw new \Exception('余额不足');
        }
        $user->account_balance = $user->account_balance - $money;
        $user->save();
    }
     private function checkPayPassword($user, $pay_password) {
        if (!$user->pay_password) {
            throw new \Exception('还没有设置支付密码');
        }
        if (!$pay_password) {
            throw new \Exception('支付密码不能为空');
        }
        if (!Hash::check($pay_password, $user->pay_password)) {
            throw new \Exception('支付密码不正确');
        }
        return true;
     }

    private function addBalanceRecord($user_id, $money)
    {
        BalanceRecord::insert([
            'user_id' => $user_id,
            'type' => 1,
            'chg_type' => 2,
            'money' => $money,
            'money_str' => '-' . $money,
            'desc' => '提现',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'status' => 0
        ]);
    }

    private function getCashRate()
    {
        $cash_rate = Config::where('config_key', 'cash_rate')->value('config_value');
        return floatval($cash_rate);
    }
}