<?php

namespace Repositories\Api\Pay;

use Repositories\PayRepository;
use Entities\User;
use Entities\Order;
use Entities\BalanceRecord as Balance;
use Hash;
use DB;
use Carbon\Carbon;

class BalancePayRepository extends PayRepository
{
    public function pay($user_id, $order_id, $pay_password)
    {
        $user = User::find($user_id);
        if (!$user) {
            throw new \Exception('用户不存在');
        }
        if (!$this->checkPayPassword($user, $pay_password)) {
            throw new \Exception('支付密码不正确');
        }

        $order = Order::where([
            ['user_id', $user_id],
            ['id', $order_id]
        ])->first();
        
        if (!$order) {
            throw new \Exception('订单不存在');
        }

        if ($order->status > 1) {
            throw new \Exception('订单已支付');
        }

        if ($this->_pay($user, $order)) {
            return true;
        } else {
            return false;
        }


    }

    private function checkPayPassword($user, $pay_password)
    {
        if (!Hash::check($pay_password, $user->pay_password)) {
            return false;
        } else {
            return true;
        }
    }

    // 处理支付
    private function _pay($user, $order)
    {
        if ($order->buy_type == 1 || $order->buy_type == 2) {
            $this->_accountBalancePay($user, $order);
        } else if ($order->buy_type == 3) {
            $this->_shopBalancePay($user, $order);
        } else {
            throw new \Exception('购买类型不正确');
        }
    }

    // 账户余额购买
    private function _accountBalancePay($user, $order)
    {
        if ($order->total_money > $user->account_balance) {
            throw new \Exception('账户余额不足');
        } else {
            DB::transaction(function () use ($user, $order) {
                $this->chgOrderStatusAfterPaySucc($order);
                $this->chgPayStatusAfterPaySucc($user->id, $order->id, $order->total_money, 'balance', 4, 'BALANCE');
                $this->_reduceUserAccountBalance($user->id, $order->total_money);
                $this->_addBalanceRecord($user->id, 1, 2, $order->total_money, '订单支付');
            });
        }
        return true;
    }

    // 购物金购买
    private function _shopBalancePay($user, $order)
    {
        if ($order->total_money > $user->shop_balance) {
            throw new \Exception('账户余额不足');
        } else {
            DB::transaction(function () {
                $this->chgOrderStatusAfterPaySucc($order);
                $this->chgPayStatusAfterPaySucc($user->id, $order->id, $order->total_money, 'balance', 4, 'BALANCE');
                $this->_reduceUserShopBalance($user->id, $order->total_money);
            });
        }
        return true;

    }

    // 扣除余额
    private function _reduceUserAccountBalance($user_id, $money)
    {
        $user = User::find($user_id);
        $user->account_balance = ($user->account_balance >= $money)
                                 ? ($user->account_balance - $money)
                                 : 0;
        $user->save();
    }

    // 扣除购物金
    private function _reduceUserShopBalance($user_id, $money)
    {
        $user = User::find($user_id);
        $user->shop_balance = ($user->shop_balance >= $money)
                                 ? ($user->shop_balance - $money)
                                 : 0;
        $user->save();
    }

    // 添加余额记录
    private function _addBalanceRecord($user_id, $type, $chg_type, $money, $desc)
    {
        if ($chg_type == 1) {
            $money_str = '+' . $money;
        } elseif ($chg_type == 2) {
            $money_str = '-' . $money;
        }

        Balance::insert([
            'user_id' => $user_id,
            'type' => $type,
            'chg_type' => $chg_type,
            'money' => $money,
            'money_str' => $money_str,
            'desc' => $desc, 
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

}