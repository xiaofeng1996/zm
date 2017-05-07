<?php

namespace App\Http\Controllers\Api\Pay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Repositories\Api\Pay\ApiPayRepository as Pay;
use Repositories\Api\Balance\BalanceRepository as Balance;

class AlipayController extends Controller
{
    /* 签名
     * @param int keytype 业务类型, 1: 订单支付, 2: 充值
     * @param int keyid 业务类型队形主键id , keytype=1时, keyid=订单id, keytype=2时, keyid=0
     */
    public function sign (Request $request, Pay $pay, Balance $balance) {
        $this->apiValidate($request, [
            'keytype' => 'required|integer',
            'keyid' => 'required|integer',
        ]);

        $keytype = $request->input('keytype');

        if ($keytype == 1) {
            $order = $pay->getOrderByUserIdAndOrderId($request->userId, $request->input('keyid'));
            $subject = '订单支付';
        } else if ($keytype == 2) {
            $order = $balance->createRecharge($request->userId, $request->input('mobile'));
            $subject = '账户充值';
        } else {
            throw new \Exception('支付类型不正确');
        }

        // 创建支付单。
        $alipay = app('alipay.mobile');
        $alipay->setOutTradeNo($order->out_trade_no);

        if (env('APP_ENV') != 'production') {
            $alipay->setTotalFee(0.01);
        } else {
            $alipay->setTotalFee($order->total_money);
        }
        $alipay->setSubject($subject);
        $alipay->setBody('goods_description');

        // 返回签名后的支付参数给支付宝移动端的SDK。
        $data['alipaysign'] = $alipay->getPayPara();
        return response()->api($data);

    }

    public function notify (Request $request, PayRepository $pay_repo) {
        // 验证请求。
        if (! app('alipay.mobile')->verify()) {
            Log::notice('Alipay notify post data verification fail.', [
                'data' => Request::instance()->getContent()
            ]);
            return 'fail';
        }

        //Log::info('支付宝回调: ', Input::all());
        // 判断通知类型。
        switch (Input::get('trade_status')) {
            case 'TRADE_SUCCESS':
            case 'TRADE_FINISHED':
                // TODO: 支付成功，取得订单号进行其它相关操作。
                //Log::debug('支付宝验签成功', Input::all());

                $total_fee = Input::get('total_fee');
                $out_trade_no = Input::get('out_trade_no');
                $trade_no = Input::get('trade_no');
                $fee_type = 'CNY';

                $order_type = substr($out_trade_no, 0, 2);

                switch ($order_type) {
                    case 'DD':
                        $pay->paySucc($out_trade_no, $total_fee, $trade_no, 1, $fee_type);
                        break;
                    case 'CZ':
                        $balance->rechargeSucc($out_trade_no, $total_fee, $trade_no, 1, $fee_type);
                        break;
                    default:
                        break;
                }

                break;
            default:
                Log::error('验签失败', Input::all());
                break;
        }
        return 'success';
    }
}