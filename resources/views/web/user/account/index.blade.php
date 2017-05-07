@extends('web.layout.main')

@push('personal_css')
    <link rel="stylesheet" href="/web/css/base/personStyle.css">
@endpush

@push('order_detail_css')
    <link rel="stylesheet" href="/web/css/personCenter/orderDetail.css">
@endpush

@push('personal_js')
    <script src="/web/js/personStyle.js"></script>
@endpush

@push('account_js')
    <script src="/web/js/myAccount.js"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <ol class="pathNavigation clearfix">
                    <li>当前位置:</li>
                    <li><a href="/">首页</a></li>
                    <li><a href="/user">个人中心</a></li>
                    <li><a>账户</a></li>
                </ol>
            </div>
        </div>
        <div class="clearfix">
            @include('web.user.personal_left')
            <!--基本信息-->
            <div class="personal-content product-list-content">
                <div class="personal-wrap">
                    <div class="person-content">
                        <div class="person-header">
                            <span class="header-title">我的账户</span>
                        </div>
                        <div class="person-body padding-bottom0">
                            <div id="person-nav" class="person-nav">
                                <ul class="clearfix">
                                    <li class="selected">
                                        <a data-target="#P-Cash">购物金</a>
                                    </li>
                                    <li>
                                        <a data-target="#cashReserve">现金余额</a>
                                    </li>
                                </ul>
                            </div>
                            <div id="P-Cash" class="nav-content">
                                <table class="account-title">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="right-border border-color-golden">
                                                总金额: <span class="fontsize-huge color-purple vam">￥{{ $user->shop_balance }}</span> <a
                                                    id="recharge" class="purple-btn2 margin-top0 inline-block">充值</a>
                                                <span class="f-split"></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span>累计消费</span>
                                            <br/><br/>
                                            <span class="color-purple fontsize-xxxlarge">￥{{ $user->comulate_shop_balance }}</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="record-list">
                                    <tbody>
                                        @foreach($shop_balance_records as $shop_balance_record)
                                            <tr>
                                                <td>
                                                    <span class="font-border">{{ $shop_balance_record->desc }}</span><br/>
                                                    <span>{{ $shop_balance_record->created_at }}</span>
                                                </td>
                                                <td>
                                                    <span class="color-purple fontsize-xxlarge">{{ $shop_balance_record->money_str }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div id="cashReserve" class="nav-content" style="display: none">
                                <table class="account-title">
                                    <tbody>
                                    <tr>
                                        <td>
                                            总金额: <span class="fontsize-huge color-purple vam">￥{{ $user->account_balance }}</span>
                                            <a href="/cash" class="purple-btn2 margin-top0 inline-block">提现</a>
                                            <span class="f-split"></span>
                                            <span class="margin-left10">设置支付/提现密码</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="record-list">
                                    <tbody>
                                        @foreach($account_balance_records as $record)
                                            <tr>
                                                <td>
                                                    <span class="font-border">{{ $record->desc }}</span><br/>
                                                    <span>{{ $record->created_at }}</span>
                                                </td>
                                                <td>
                                                    <span class="color-purple fontsize-xxlarge">{{ $record->money_str }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 规则 -->
    <div class="modal ruleModal fade" id="ruleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title font-border title-left" id="myModalLabel">消费=免费专区交易规则</h4>
                </div>
                <div class="modal-body">
                    <p>
                        第一条　本规则依据财政部《彩票发行与销售管理暂行规定》和《中国福利彩票（电脑型）联合发行与销售管理暂行办法》（以下简称《管理办法》）制定本规则。
                    </p>
                    <p>
                        第二条　中国福利彩票“双色球”（以下简称“双色球”）是一种联合发行的“乐透型”福利彩票。采用计算机网络系统发行销售，定期电视开奖。
                    </p>
                    <p>
                        第三条　“双色球”由中国福利彩票发行管理中心（以下简称中福彩中心）统一组织发行，在全国销售。
                    </p>
                    <p>
                        第四条　参与“双色球”销售的省级行政区域福利彩票发行中心（以下称省中心）在中福彩中心的直接领导下，负责对本地区的“双色球”销售活动实施具体的组织和管理。
                    </p>
                    <p>
                        第五条　“双色球”彩票实行自愿购买，凡购买者均被视为同意并遵守本规则
                        本规则。
                    </p>
                    <p>
                        第六条　“双色球”彩票投注区分为红色球号码区和蓝色球号码区。

                    </p>
                    <p>
                        第七条　“双色球”每注投注号码由6个红色球号码和1个蓝色球号码组成。红色球号码从1--33中选择；蓝色球号码从1--16中选择。
                    </p>
                </div>
                <div class="modal-footer">
                    <button id="goPay" type="button" class="btn btn-primary">去支付</button>
                </div>
            </div>
        </div>
    </div>
    <!--支付对话框-->
    <div id="payDialog" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center bg-purple color-white">
                    <span class="icon icon-left-cloud"></span>
                    <span>选择支付方式</span>
                    <span class="icon icon-right-cloud"></span>

                    <button type="button" class="close color-white" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <div class="input-item">
                        <div class="input-group">
                            <label for="rechargeNum">充值金额:</label>
                            <input type="text" id="rechargeNum" value="200" disabled="disabled"/>
                        </div>
                    </div>
                    <div class="input-item">
                        <div class="input-group">
                            <label for="referrer">推荐人:</label>
                            <input type="text" id="referrer" placeholder="输入推荐人手机号" />
                            <a id="contact" class="icon icon-contact"></a>
                        </div>
                    </div>
                    <p class="color-golden text-center">选择支付方式</p>
                    <div class="pay-item" data-payType="支付宝">
                        <label for="pay-zfb" class="pay-radio on">
                            <span class="pip"></span>
                        </label>
                        <input id="pay-zfb" type="radio" name="pay-type" value="1">
                        <span class="icon icon-pay-zfb vab margin-left20"></span>
                    </div>
                    <div class="pay-item" data-payType="微信支付">
                        <label for="pay-wx" class="pay-radio">
                            <span class="pip"></span>
                        </label>
                        <input id="pay-wx" type="radio" name="pay-type" value="2">
                        <span class="icon icon-pay-wx vab margin-left20"></span>
                    </div>
                    <div class="pay-item" data-payType="中国银联">
                        <label for="pay-yl" class="pay-radio">
                            <span class="pip"></span>
                        </label>
                        <input id="pay-yl" type="radio" name="pay-type" value="3">
                        <span class="icon icon-pay-yl vab margin-left20"></span>
                    </div>
                    {{--<div class="pay-item" data-payType="余额支付">--}}
                        {{--<label for="pay-yezf" class="pay-radio">--}}
                            {{--<span class="pip"></span>--}}
                        {{--</label>--}}
                        {{--<input id="pay-yezf" type="radio" name="pay-type" value="4">--}}
                        {{--<span class="icon icon-pay-yezf margin-left20 vabaseline"></span>--}}
                        {{--<div class="inline-block margin-left5">--}}
                            {{--<div class="fontsize-large">余额支付</div>--}}
                            {{--<div class="fontsize-normal">(可用余额￥300)</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <a id="payNow" class="button-purple margin-left35 margin-right35">立即支付</a>
                </div>
            </div>
        </div>
    </div>


    <!--支付对话框-->
    <div id="contactDialog" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center bg-purple color-white">
                    <span class="icon icon-left-cloud"></span>
                    <span>选择联系人</span>
                    <span class="icon icon-right-cloud"></span>

                    <button type="button" class="close color-white" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    @if (count($contacts))
                        <ul>
                            @foreach ($contacts as $key => $contact)
                                <li class="contact-item" data-mobile="{{ $contact->invite_user_mobile }}">
                                    <label for="cnum{{ $key }}" class="pay-radio">
                                        <span class="pip"></span>
                                    </label>
                                    <input id="cnum{{ $key }}" type="radio" name="pay-type" value="{{ $contact->invite_user_mobile }}">
                                    <div class="contact-info">
                                        <span class="ci-name">{{ $contact->invite_user_name }}</span>
                                        <br/>
                                        <span class="ci-phone">{{ $contact->invite_user_mobile }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <a id="contactOk" class="button-purple margin-left35 margin-right35">确定</a>
                    @else
                        <p style="line-height: 200px; text-align: center;">没有可选联系人</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        var payObj = {
            data: {
                pay_type: 0, // 0: 模拟支付, 1: 支付宝, 2: 微信, 3: 银联, 4: 余额
                pay_data: {
                    _token: "{{ csrf_token() }}",
                    keytype: 2,
                    keyid: 0,
                    mobile: ''
                }
            },
            init: function () {
                payObj.methods.listenContactSel();
                payObj.methods.listenContactOk();
                payObj.methods.listenPayClick();
            },
            methods: {
                listenContactSel: function () {
                    $(".contact-item").click(function () {
                        var mobile = $(this).attr('data-mobile');
                        $("#referrer").val(mobile);
                    });
                },
                listenContactOk: function () {
                    $("#contactOk").click(function () {
                        $("#contactDialog").modal('hide');
                    });
                },
                listenPayClick: function () {
                    $("#payNow").click(function () {
                        console.log('aha');
                        payObj.methods.pay();
                    });
                },
                pay: function () {
                    payObj.data.pay_data.mobile = $("#referrer").val();
                    switch(payObj.data.pay_type) {
                        case 0:
                            var url = '/sumilate';
                            break;
                        case 1:
                            var url = '/alipay';
                            break;
                        case 2:
                            var url = '/wxpay';
                            break;
                        case 3:
                            var url = '/unionpay';
                            break;
                    }
                    $.ajax({
                        url: url,
                        method: 'post',
                        data: payObj.data.pay_data,
                        success: function (data) {
                            if (data.success == 1) {
                                $("#payDialog").modal("hide");
                                payObj.data.methods.clearData();
                            } else {
                                alert(data.infor);
                            }
                        }
                    })
                },
                clearData: function () {
                    payObj.data.pay_data.mobile = '';
                }
            }
        }
        payObj.init();
    </script>
@endsection
