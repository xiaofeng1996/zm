<?php

namespace App\Http\Controllers\Web\Pay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WxpayController extends Controller
{
    /* 发起支付
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

//        $gateway    = Omnipay::create('WechatPay_App');
//        $gateway->setAppId($config['app_id']);
//        $gateway->setMchId($config['mch_id']);
//        $gateway->setApiKey($config['api_key']);
//
//        $order = [
//            'body'              => 'The test order',
//            'out_trade_no'      => date('YmdHis').mt_rand(1000, 9999),
//            'total_fee'         => 1, //=0.01
//            'spbill_create_ip'  => 'ip_address',
//            'fee_type'          => 'CNY'
//        ];

        /**
         * @var Omnipay\WechatPay\Message\CreateOrderRequest $request
         * @var Omnipay\WechatPay\Message\CreateOrderResponse $response
         */
        $request  = $gateway->purchase($order);
        $response = $request->send();

        // 创建支付单。
        $alipay = app('alipay.web');
        $alipay->setOutTradeNo($order->out_trade_no);
        if (env('APP_ENV') != 'production') {
            $alipay->setTotalFee(0.01);
        } else {
            $alipay->setTotalFee($order->total_money);
        }
        $alipay->setSubject($subject);
        $alipay->setBody('goods_description');

        return redirect()->to($alipay->getPayLink());

    }
}
