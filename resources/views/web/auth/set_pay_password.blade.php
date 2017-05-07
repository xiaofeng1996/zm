@extends('web.layout.main')

@push('personal_css')
    <link rel="stylesheet" href="/web/css/base/personStyle.css">
@endpush

@push('order_detail_css')
    <link rel="stylesheet" href="/web/css/personCenter/orderDetail.css">
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <ol class="pathNavigation clearfix">
                    <li>当前位置:</li>
                    <li><a href="/user">个人中心</a></li>
                    <li><a href="/account">我的账户</a></li>
                    <li><a>设置提现密码</a></li>
                </ol>
            </div>
        </div>
        <div class="clearfix">
            @include('web.user.personal_left')
            <!--基本信息-->
            <div class="personal-content padding15">

                <div class="person-content">
                    <div class="person-header">
                        <span class="header-title">确认提现信息</span>
                    </div>
                    <div class="person-body">
                        <div class="cash-form-box">
                            <form action="/pay_password/save" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group clearfix">
                                    <label for="phoneNum" class="pull-left"></label>
                                    @if ($errors->first())
                                        <p class="err-msg">{{ $errors->first() }}</p>
                                    @endif
                                    @if (session('set_err'))
                                        <p class="err-msg">{{ session('set_err') }}</p>
                                    @endif
                                </div>
                                <div class="form-group clearfix">
                                    <label for="phoneNum" class="pull-left">手机号:</label>
                                    <input type="text" name="mobile" class="input-text-width-lg" id="phoneNum" placeholder="请输入手机号"/>
                                </div>
                                <div class="form-group clearfix">
                                    <label for="setPass" class="pull-left">设置密码:</label>
                                    <input type="password" name="password" class="input-text-width-lg" id="setPass" placeholder="密码由6~20位字母,数字和自负组成"/>
                                </div>
                                <div class="form-group clearfix">
                                    <label for="rePass" class="pull-left">确认密码:</label>
                                    <input type="password" name="re_password" class="input-text-width-lg" id="rePass" placeholder="请再次输入上面密码"/>
                                </div>
                                <div class="form-group clearfix">
                                    <label for="verificationCode" class="pull-left">验证码:</label>
                                    <div class="verification-input input-group">
                                        <input type="text" name="code" class="input-text-width-lg" id="verificationCode" placeholder="请输入验证码"/>
                                        <a id="verify-code-container" style="cursor: pointer;" class="color-golden"><span id="get-verify-code" class="margin-left5 color-purple">发送验证码</span></a>
                                    </div>

                                </div>
                                <button id="okBtn" class="purple-btn">确定</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var setObj = {
            data: {
                seconds: 60
            },
            methods: {
                listenCodeClick: function () {
                    $("#get-verify-code").click(function () {
                        setObj.data.seconds = 60;
                        setObj.methods.getVerifyCode();
                    });
                },
                getVerifyCode: function () {
                    var mobile = $("input[name='mobile']")[0].value;
                    if (!mobile) {
                        alert('请先填写手机号');
                    } else {
                        $.ajax({
                            url: '/code/send',
                            method: 'get',
                            data: {
                                mobile: mobile
                            },
                            success: function (data) {
                                setObj.methods.timeCountDown();
                            }
                        })
                    }
                },
                timeCountDown: function () {
                    if (setObj.data.seconds <= 0) {
                        $("#verify-code-container").html('<span id="get-verify-code" class="margin-left5 color-purple">重新获取验证码</span>');
                    } else {
                        setObj.data.seconds--;
                        $("#verify-code-container").html('<span id="get-verify-code" class="margin-left5 color-purple" >' + setObj.data.seconds + 's后重新获取</p>');
                        setTimeout('setObj.methods.timeCountDown()', 1000);
                    }
                }
            }
        }
        setObj.methods.listenCodeClick();
    </script>
@endsection
