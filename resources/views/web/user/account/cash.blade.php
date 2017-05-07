@extends('web.layout.main')

@push('personal_css')
    <link rel="stylesheet" href="/web/css/base/personStyle.css">
@endpush

@push('order_detail_css')
    <link rel="stylesheet" href="/web/css/personCenter/orderDetail.css">
@endpush

@push('cash_css')
    <link rel="stylesheet" href="/web/css/personCenter/cash.css">
@endpush

@push('personal_js')
    <script src="/web/js/personStyle.js"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <ol class="pathNavigation clearfix">
                    <li>当前位置:</li>
                    <li><a href="/">首页</a></li>
                    <li><a href="/user">个人中心</a></li>
                    <li><a href="/account">我的账户</a></li>
                    <li><a>提现</a></li>
                </ol>
            </div>
        </div>
        <div class="clearfix">
            @include('web.user.personal_left')
            <!--基本信息-->
            <div class="personal-content padding15">
                <div class="person-content" id="cash-info">
                    <div class="person-header">
                        <span class="header-title">提现</span>
                    </div>
                    <div class="person-body">
                        <div class="cash-title">
                            可提现金额: <span class="fontsize-xxxlarge color-purple">￥{{ $user->account_balance }}</span>
                        </div>
                        <hr class="hr-khaki"/>
                        <div class="cash-form-box">
                            <span>选择提现方式</span>
                            <div class="pay-nav margin-top30">
                                <ul class="clearfix">
                                    <li id="ali-cash-nav" class="selected" data-target="#zfbPayContent">
                                        <div class="pay-type-zfb">
                                            <div class="pay-radio on">
                                                <div class="pip">

                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="union-cash-nav" data-target="#ylPayContent">
                                        <div class="pay-type-yl" data-target="#zfbPayContent">
                                            <div class="pay-radio">
                                                <div class="pip">

                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div id="zfbPayContent" class="pay-nav-content">
                                <form>
                                    <div class="form-group clearfix">
                                        <label for="zfbAccount" class="pull-left">支付宝账号:</label>
                                        <input id="zfbAccount" class="pull-left" type="text" placeholder="请输入支付宝账号"/>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label for="cashAmount" class="pull-left">提现金额:</label>
                                        <div class="input-group pull-left">
                                            <span class="icon icon-rmb"></span>
                                            <input type="text" id="cashAmount" placeholder="请输入提现金额"/>
                                        </div>
                                        <a class="input-link pull-left">忘记提现密码?</a>
                                    </div>
                                    <a id="zfbPayNext" class="purple-btn">下一步</a>
                                </form>
                            </div>
                            <div id="ylPayContent"  class="pay-nav-content"  style="display:none">
                                <form>
                                    <div class="form-group clearfix">
                                        <label for="ylAccount" class="pull-left">银行卡号:</label>
                                        <div class="account-input input-group pull-left">
                                            <input id="ylAccount" class="pull-left" type="text" value="" readonly/>
                                            <a class="text-link">管理<span class="glyphicon glyphicon-play"></span></a>
                                        </div>

                                    </div>
                                    <div class="form-group clearfix">
                                        <label for="cashAmount" class="pull-left">提现金额:</label>
                                        <div class="input-group pull-left">
                                            <span class="icon icon-rmb"></span>
                                            <input type="text" id="ylCashAmount" placeholder="请输入提现金额"/>
                                        </div>
                                        <div class="note">
                                            <span>住<sup>*</sup>:手续费5%</span>
                                        </div>
                                    </div>
                                    <a id="ylPayNext" class="purple-btn">下一步</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- 确认提现信息 --}}
                <div class="person-content" id="cash-confirm" style="display: none;">
                    <div class="person-header">
                        <span class="header-title">确认提现信息</span>
                    </div>
                    <div class="person-body">
                        <div id="confirm-content">
                        </div>
                        <hr class="hr-khaki"/>
                        <div class="cash-form-box">
                            <form>
                                <div class="form-group clearfix">
                                    <label for="payPass" class="pull-left">支付密码:</label>
                                    <div class="input-group pull-left">
                                        <input type="password" class="input-text-width-lg" id="payPass" placeholder="请输入提现金额"/>
                                    </div>
                                    <a class="input-link pull-left">忘记密码?</a>
                                    <a class="input-link pull-left">设置密码</a>
                                </div>

                                <a id="cashBtn" class="purple-btn">确认提现</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var cashObj = {
            data: {
                _token: "{{ csrf_token() }}",
                apply_type: 2,
                ali_account: '',
                bank_name: '',
                bank_card_no: '',
                bank_user_name: '',
                money: '',
                pay_password: ''
            },
            init: function () {
                cashObj.methods.listenAlipayNext();
                cashObj.methods.listenYlPayNext();
                cashObj.methods.listenSubmit();
                cashObj.methods.listenUrl();
                cashObj.methods.listenNav();
                cashObj.methods.listenUnionAccountClick();
            },
            methods: {
                listenAlipayNext: function () {
                    $("#zfbPayNext").click(function () {
                        var ali_account = $("#zfbAccount").val();
                        var money = $("#cashAmount").val();
                        if (!ali_account) {
                            alert('请先填写支付宝账号');
                        } else if (!money) {
                            alert('请填写提现金额');
                        } else {
                            cashObj.data.apply_type = 2;
                            cashObj.data.ali_account = ali_account;
                            cashObj.data.money = money;
                            cashObj.methods.next();
                        }
                    });
                },
                listenYlPayNext: function () {
                    $("#ylPayNext").click(function () {
                        if (!cashObj.data.bank_name) {
                            alert('请先填写银行卡信息');
                        } else {
                            cashObj.data.apply_type = 1;
                            cashObj.data.money = $("#ylCashAmount").val();
                            cashObj.methods.next()
                        };
                    });
                },
                // 下一步
                next: function () {
                    $("#cash-info").css("display", "none");
                    $("#cash-confirm").css("display", "block");
                    if (cashObj.data.apply_type == 1) {
                        var template = '<div class="cash-title">'
                        template +=         '<span class="font-border">银行卡信息</span>'
                        template +=         '<br/> <br/>'
                        template +=         '<p>' + cashObj.data.bank_user_name + '</p>'
                        template +=         '<p>' + cashObj.data.bank_name + '(' + cashObj.data.bank_card_no + ')</p>'
                        template +=         '<p>提现金额<span class="color-purple">￥' + cashObj.data.money + '</span></p>'
                        template +=     '</div>';
                        $("#confirm-content").html(template);
                    } else {
                        var template = '<div class="cash-title">';
                        template +=         '<p>支付宝账号: ' + cashObj.data.ali_account + '</p>';
                        template +=         '<p>提现金额&nbsp;&nbsp;: ' + cashObj.data.money + '</p>';
                        template +=     '</div>';
                        $("#confirm-content").html(template);
                    }
                },
                listenSubmit: function () {
                    $("#cashBtn").click(function () {
                        cashObj.data.pay_password = $("#payPass").val();
                        $.ajax({
                            url: '/cash',
                            method: 'post',
                            data: cashObj.data,
                            success: function (data) {
                                if (data.success == 1) {
                                    window.location.href = '/account';
                                } else {
                                    alert(data.infor);
                                }
                            },
                            error: function () {
                                alert('提现失败');
                            }
                        })
                    });
                },
                listenUrl: function () {
                    var url = window.location.href;
                    var apply_type = url.split('#')[1];
                    if (apply_type == 'union') {
                        cashObj.methods.showUnionCash();
                    } else {
                        cashObj.methods.showAliCash();
                    }
                },
                listenNav: function () {
                     $('.pay-nav ul>li').click(function(){
                         var id = $(this).attr('id');
                         if (id == "ali-cash-nav") {
                             cashObj.methods.showAliCash();
                         } else {
                             cashObj.methods.showUnionCash();
                         }
                     });
                },
                showAliCash: function () {
                    $("#ali-cash-nav").addClass("selected");
                    $("#union-cash-nav").removeClass("selected");
                    $("#zfbPayContent").css("display", "block");
                    $("#ylPayContent").css("display", "none");
                    window.location.href = window.location.href.split("#")[0] + '#' + 'ali';
                },
                showUnionCash: function () {
                    $("#union-cash-nav").addClass("selected");
                    $("#ali-cash-nav").removeClass("selected");
                    $("#zfbPayContent").css("display", "none");
                    $("#ylPayContent").css("display", "block");
                    var url = window.location.href;
                    var params = decodeURI(window.location.search).replace(/\?/, '').split("&");
                    if (params && params.length) {
                        cashObj.methods.setData(params);
                        cashObj.methods.showUnionData();
                    }
                    window.location.href = url.split("#")[0] + '#' + 'union';
                },
                setData: function (params) {
                    for(var i = 0; i < params.length; i++) {
                        var param = params[i];
                        var p = param.split("=");
                        var name = p[0];
                        switch (name) {
                            case 'bank_user_name':
                                cashObj.data.bank_user_name = p[1];
                                break;
                            case 'bank_card_no':
                                cashObj.data.bank_card_no = p[1];
                                break;
                            case 'bank_name':
                                cashObj.data.bank_name = p[1];
                                break;
                            default:
                                break;
                        }
                    }
                },
                showUnionData: function () {
                    if (cashObj.data.bank_name && cashObj.data.bank_card_no) {
                        $("#ylAccount").val(cashObj.data.bank_name + ' 尾号:' + cashObj.data.bank_card_no.slice(-4));
                    } else {
                        $("#ylAccount").val('点击选择支持提现的银行');
                    }
                },
                listenUnionAccountClick: function () {
                    $("#ylAccount").click(function () {
                        window.location.href = '/union/create';
                    });
                }
            }
        }
        cashObj.init();
    </script>
@endsection
